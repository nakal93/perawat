<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\KaryawanSettingsRequest;
use App\Models\Karyawan;
use App\Models\Ruangan;
use App\Models\Profesi;
use Illuminate\Support\Facades\Storage;
use App\Models\DokumenKaryawan;
use App\Models\KategoriDokumen;
use Illuminate\Support\Carbon;

class KaryawanController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $karyawan = $user->karyawan;
        // Default empty stats if belum ada profil
        $metrics = [
            'total' => 0,
            'aktif' => 0,
            'akan_expire' => 0,
            'expired' => 0,
        ];
        $chartKategori = ['labels' => [], 'data' => []];
        $chartStatus = ['labels' => ['Aktif', 'Akan Expire', 'Expired'], 'data' => [0,0,0]];
        $chartUploads = ['labels' => [], 'data' => []];

    $requiredCategories = collect();
    $missingCategories = collect();
    $percentComplete = 0;

    if ($karyawan) {
            $today = now()->startOfDay();
            $soon = now()->addDays(30)->endOfDay();

            $total = DokumenKaryawan::where('karyawan_id', $karyawan->id)->count();
            $aktif = DokumenKaryawan::where('karyawan_id', $karyawan->id)
                ->where(function($q) use ($today) {
                    $q->where('berlaku_seumur_hidup', true)
                      ->orWhere(function($q2) use ($today) { $q2->whereNotNull('tanggal_berakhir')->where('tanggal_berakhir', '>=', $today); });
                })->count();
            $akanExpire = DokumenKaryawan::where('karyawan_id', $karyawan->id)
                ->where('berlaku_seumur_hidup', false)
                ->whereNotNull('tanggal_berakhir')
                ->whereBetween('tanggal_berakhir', [$today, $soon])
                ->count();
            $expired = DokumenKaryawan::where('karyawan_id', $karyawan->id)
                ->where('berlaku_seumur_hidup', false)
                ->whereNotNull('tanggal_berakhir')
                ->where('tanggal_berakhir', '<', $today)
                ->count();

            $metrics = [
                'total' => $total,
                'aktif' => $aktif,
                'akan_expire' => $akanExpire,
                'expired' => $expired,
            ];

            // Dokumen per kategori
            $perKategori = DokumenKaryawan::with('kategoriDokumen')
                ->where('karyawan_id', $karyawan->id)
                ->get()
                ->groupBy(function($d){ return optional($d->kategoriDokumen)->nama_kategori ?? 'Lainnya'; })
                ->map->count();
            $chartKategori = [
                'labels' => array_values($perKategori->keys()->toArray()),
                'data' => array_values($perKategori->values()->toArray()),
            ];

            // Upload per bulan (6 bulan terakhir)
            $allDocs = DokumenKaryawan::where('karyawan_id', $karyawan->id)->get();
            $labels = [];
            $counts = [];
            for ($i = 5; $i >= 0; $i--) {
                $start = now()->copy()->startOfMonth()->subMonths($i);
                $end = $start->copy()->endOfMonth();
                $label = $start->format('M Y');
                $labels[] = $label;
                $count = $allDocs->filter(function($d) use ($start, $end) {
                    return $d->created_at && $d->created_at->between($start, $end);
                })->count();
                $counts[] = $count;
            }
            $chartUploads = ['labels' => $labels, 'data' => $counts];

            // Status chart
            $chartStatus = [
                'labels' => ['Aktif', 'Akan Expire', 'Expired'],
                'data' => [$aktif, $akanExpire, $expired],
            ];

            // Completeness: required categories vs uploaded
            $requiredCategories = KategoriDokumen::where('wajib', true)->get(['id','nama_kategori']);
            $uploadedCatIds = DokumenKaryawan::where('karyawan_id', $karyawan->id)
                ->pluck('kategori_dokumen_id')
                ->filter()
                ->unique();
            $missingCategories = $requiredCategories->filter(function($cat) use ($uploadedCatIds) {
                return !$uploadedCatIds->contains($cat->id);
            })->values();
            $totalReq = max(0, $requiredCategories->count());
            $done = $totalReq > 0 ? ($totalReq - $missingCategories->count()) : 0;
            $percentComplete = $totalReq > 0 ? round(($done / $totalReq) * 100) : 0;
        }

        return view('karyawan.dashboard', compact('karyawan', 'metrics', 'chartKategori', 'chartStatus', 'chartUploads', 'requiredCategories', 'missingCategories', 'percentComplete'));
    }

    public function profile()
    {
        $user = auth()->user();
        $karyawan = $user->karyawan;
        $ruangan = Ruangan::all();
        $profesi = Profesi::all();

        if (!$karyawan) {
            return view('karyawan.create-profile', compact('ruangan', 'profesi'));
        }

        // Jika profil sudah ada tapi field inti belum lengkap, arahkan ke form lengkapi (wajib)
        $missingCore = empty($karyawan->nik) || empty($karyawan->status_pegawai_id) || empty($karyawan->tanggal_lahir) ||
            ((optional($karyawan->statusPegawai)->nama === 'PNS' || optional($karyawan->statusPegawai)->nama === 'PPPK') && empty($karyawan->nip));
        if ($missingCore) {
            return view('karyawan.create-profile', compact('ruangan', 'profesi', 'karyawan'));
        }

        // Pastikan setiap karyawan aktif memiliki qr_token permanen
        try {
            $karyawan->ensureQrToken();
        } catch (\Throwable $e) {
            // Jangan gagalkan halaman profil jika terjadi error token; cukup log bila diperlukan
            \Log::warning('Gagal generate qr_token: '.$e->getMessage());
        }

        // Generate QR code jika user sudah aktif
        $qrcode = null;
        if ($user->status === 'active' && $karyawan->qr_token) {
            $targetUrl = route('qr.public', $karyawan->qr_token);
            $qrcode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(160)->generate($targetUrl);
        }

        return view('karyawan.profile', compact('karyawan', 'ruangan', 'profesi', 'qrcode'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $existing = $user->karyawan;
        $allowWhenMissingCore = $existing && (empty($existing->nik) || empty($existing->status_pegawai_id) || empty($existing->tanggal_lahir) || ((optional($existing->statusPegawai)->nama === 'PNS' || optional($existing->statusPegawai)->nama === 'PPPK') && empty($existing->nip)));
        if ($user->status !== 'pending' && !$allowWhenMissingCore) {
            return redirect()->back()->with('error', 'Profil tidak dapat diubah setelah disetujui.');
        }

        $validated = $request->validate([
            'nik' => 'required|string|max:16|unique:karyawan,nik,' . ($user->karyawan->id ?? 'NULL'),
            'nip' => 'nullable|string|max:30|unique:karyawan,nip,' . ($user->karyawan->id ?? 'NULL'),
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'ruangan_id' => 'required|exists:ruangan,id',
            'profesi_id' => 'required|exists:profesi,id',
            'status_pegawai_id' => 'required|exists:status_pegawai,id',
        ]);

        // Validasi tambahan: nip wajib jika status pegawai PNS atau PPPK
        $statusId = $validated['status_pegawai_id'];
        $statusNama = \App\Models\StatusPegawai::find($statusId)?->nama;
        if (in_array($statusNama, ['PNS','PPPK']) && empty($validated['nip'])) {
            return redirect()->back()->withErrors(['nip' => 'NIP wajib diisi untuk status '.$statusNama])->withInput();
        }

        $karyawan = $user->karyawan ?? new Karyawan(['user_id' => $user->id]);
        $karyawan->fill($validated);
        $karyawan->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function completeRegistration(Request $request)
    {
        $user = auth()->user();
        
        if ($user->status !== 'approved') {
            return redirect()->back()->with('error', 'Registrasi dapat dilengkapi setelah disetujui admin.');
        }

        $validated = $request->validate([
            'foto_profil' => 'nullable|image|max:2048',
            'agama' => 'required|string|max:50',
            'pendidikan_terakhir' => 'required|string|max:100',
            'gelar' => 'nullable|string|max:50',
            'kampus' => 'nullable|string|max:100',
        ]);

        $karyawan = $user->karyawan;
        
        if ($request->hasFile('foto_profil')) {
            if ($karyawan->foto_profil) {
                Storage::disk('public')->delete($karyawan->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        $karyawan->update($validated);
        $karyawan->update(['status_kelengkapan' => 'tahap2']);
        $user->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Registrasi berhasil dilengkapi.');
    }

    public function adminCreate()
    {
        $ruangan = Ruangan::all();
        $profesi = Profesi::all();
        
        return view('admin.karyawan.create', compact('ruangan', 'profesi'));
    }

    public function settings()
    {
        $user = auth()->user();
        $karyawan = $user->karyawan;
        return view('karyawan.settings', compact('user', 'karyawan'));
    }

    public function updateSettings(KaryawanSettingsRequest $request)
    {
        $user = auth()->user();
        $karyawan = $user->karyawan;
        $data = $request->validated();
        if (($data['pendidikan_terakhir'] ?? null) === 'Lainnya' && $request->filled('pendidikan_terakhir_lainnya')) {
            $data['pendidikan_terakhir'] = $request->input('pendidikan_terakhir_lainnya');
        }

        if (isset($data['name']) || isset($data['email'])) {
            $user->fill(array_intersect_key($data, array_flip(['name','email'])));
            $user->save();
        }

        if ($request->hasFile('foto_profil') && $karyawan) {
            if ($karyawan->foto_profil) {
                Storage::disk('public')->delete($karyawan->foto_profil);
            }
            $path = $request->file('foto_profil')->store('foto-profil', 'public');
            $karyawan->update(['foto_profil' => $path]);
        }

    if (!empty($data['password'])) {
            $user->update(['password' => bcrypt($data['password'])]);
        }

        // Update karyawan profile fields kalau ada input
        if ($karyawan) {
            $profileFields = [
                'nik','nip','status_pegawai_id','tanggal_lahir','jenis_kelamin','alamat','alamat_detail','provinsi_id','kabupaten_id','kecamatan_id','kelurahan_id','ruangan_id','profesi_id','agama','pendidikan_terakhir','gelar','kampus','no_hp','golongan_darah','status_perkawinan','nama_ibu_kandung','tanggal_masuk_kerja'
            ];
            $updatePayload = [];
            foreach ($profileFields as $f) {
                if (array_key_exists($f, $data)) {
                    $val = $data[$f];
                    if ($f === 'golongan_darah' && $val === 'NA') { $val = null; }
                    if ($val === '') { $val = null; }
                    $updatePayload[$f] = $val;
                }
            }
            // Re-compose alamat string if granular parts provided and alamat not explicitly posted
            $hasGranular = ($data['provinsi_id'] ?? null) || ($data['kabupaten_id'] ?? null) || ($data['kecamatan_id'] ?? null) || ($data['kelurahan_id'] ?? null) || ($data['alamat_detail'] ?? null);
            if ($hasGranular) {
                // build readable string from available relation names if loaded, else fallback to existing alamat_detail + ids
                $parts = [];
                if (!empty($updatePayload['alamat_detail'])) $parts[] = $updatePayload['alamat_detail'];
                // We might not have loaded relations here; keep original alamat if no detail
                // Simpler: Keep existing alamat if not overwritten by hidden field (already provided). Hidden field should carry composed value.
                if (isset($data['alamat'])) {
                    $updatePayload['alamat'] = $data['alamat'];
                }
            }
            if (!empty($updatePayload)) {
                $karyawan->update($updatePayload);
            }
        }

        return back()->with('success', 'Pengaturan akun berhasil diperbarui.');
    }
}

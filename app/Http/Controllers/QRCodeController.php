<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Karyawan;

class QRCodeController extends Controller
{
    public function show(Karyawan $karyawan, Request $request)
    {
    // Redirect legacy numeric route ke token route agar tidak bisa ditebak
    $token = $karyawan->ensureQrToken();
    return redirect()->route('qr.public', $token);
    }

    public function publicToken($token)
    {
        $karyawan = Karyawan::with(['user','profesi','ruangan'])->where('qr_token', $token)->firstOrFail();
        return view('qr.verify', compact('karyawan'));
    }
    public function generate(Request $request, $id)
    {
        // Tetap disediakan (jika masih dipakai tempat lain) namun sekarang hanya mengembalikan QR token URL
        $karyawan = Karyawan::with('user')->findOrFail($id);
        $token = $karyawan->ensureQrToken();
        $targetUrl = route('qr.public', $token);

        $qrCode = QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->generate($targetUrl);

        return response($qrCode)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'inline; filename="qr-'.$karyawan->id.'.png"');
    }
    
    public function download($type = 'png')
    {
        $user = auth()->user();
        $karyawan = $user->karyawan;

        if (!$karyawan) {
            abort(404, 'Data karyawan tidak ditemukan');
        }

        $token = $karyawan->ensureQrToken();
        $targetUrl = route('qr.public', $token);

        $type = strtolower($type) === 'svg' ? 'svg' : 'png';
        $filename = 'qr-code-'.$token.'.'.$type;
        $storagePath = 'qr-codes/'.$filename;

        // Cache file agar permanen (tidak berubah-ubah)
        if (!Storage::disk('public')->exists($storagePath)) {
            $qr = QrCode::format($type)
                ->size(600) // ukuran besar agar tajam dicetak lalu bisa di-resize
                ->margin(2)
                ->generate($targetUrl);
            Storage::disk('public')->put($storagePath, $qr);
        }

        $contents = Storage::disk('public')->get($storagePath);
        $mime = $type === 'svg' ? 'image/svg+xml' : 'image/png';

        return response($contents)
            ->header('Content-Type', $mime)
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
    
    public function verify(Request $request)
    {
        $qrData = $request->input('qr_data');
        
        try {
            $data = json_decode($qrData, true);
            
            if (!$data || !isset($data['id'])) {
                return response()->json(['error' => 'Invalid QR code'], 400);
            }
            
            $karyawan = Karyawan::with(['user', 'profesi', 'ruangan'])
                               ->find($data['id']);
            
            if (!$karyawan) {
                return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $karyawan->id,
                    'nama' => $karyawan->user->name,
                    'nip' => $karyawan->nip,
                    'profesi' => $karyawan->profesi->nama_profesi ?? null,
                    'ruangan' => $karyawan->ruangan->nama_ruangan ?? null,
                    'status' => $karyawan->user->status,
                    'verified_at' => now()->toISOString(),
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid QR code format'], 400);
        }
    }
}

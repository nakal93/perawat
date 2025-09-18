<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\StatusPegawai;

class KaryawanSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $user = $this->user();
        $karyawan = $user?->karyawan;
        $karyawanId = $karyawan->id ?? 'NULL';

        $rules = [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'foto_profil' => 'sometimes|image|max:2048',
            'password' => 'nullable|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/',
            'nik' => 'nullable|string|max:16|unique:karyawan,nik,' . $karyawanId,
            'nip' => 'nullable|string|max:30|unique:karyawan,nip,' . $karyawanId,
            'status_pegawai_id' => 'nullable|exists:status_pegawai,id',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'provinsi_id' => 'nullable|exists:provinsi,id',
            'kabupaten_id' => 'nullable|exists:kabupaten,id',
            'kecamatan_id' => 'nullable|exists:kecamatan,id',
            'kelurahan_id' => 'nullable|exists:kelurahan,id',
            'alamat_detail' => 'nullable|string|max:500',
            'ruangan_id' => 'nullable|exists:ruangan,id',
            'profesi_id' => 'nullable|exists:profesi,id',
            'agama' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'gelar' => 'nullable|string|max:50',
            'kampus' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:25',
            'golongan_darah' => 'nullable|string|max:3',
            'status_perkawinan' => 'nullable|string|max:30',
            'nama_ibu_kandung' => 'nullable|string|max:100',
            'tanggal_masuk_kerja' => 'nullable|date',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Password minimal 6 karakter.',
            'password.regex' => 'Password harus mengandung minimal 1 huruf kecil, 1 huruf besar, dan 1 angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($v){
            $statusId = $this->input('status_pegawai_id');
            $statusNama = $statusId ? StatusPegawai::find($statusId)?->nama : null;
            $nip = $this->input('nip');
            $existingNip = $this->user()?->karyawan?->nip;
            if (in_array($statusNama, ['PNS','PPPK'])) {
                if (!$nip && !$existingNip) {
                    $v->errors()->add('nip', 'NIP wajib diisi untuk status ' . $statusNama);
                }
            }
        });
    }
}

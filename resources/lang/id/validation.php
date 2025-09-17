<?php

return [
    'required' => 'Kolom :attribute wajib diisi.',
    'confirmed' => ':Attribute tidak sama dengan konfirmasi.',
    'min' => [
        'string' => ':Attribute minimal :min karakter.',
    ],
    'regex' => ':Attribute harus mengandung huruf besar dan angka.',
    'email' => 'Format :attribute tidak valid.',
    'unique' => ':Attribute sudah digunakan.',
    'image' => ':Attribute harus berupa gambar yang valid.',
    'max' => [
        'file' => 'Ukuran :attribute tidak boleh lebih dari :max KB.',
        'string' => ':Attribute tidak boleh lebih dari :max karakter.',
    ],
    'exists' => ':Attribute tidak valid.',

    'attributes' => [
        'name' => 'nama',
        'email' => 'email',
        'password' => 'kata sandi',
        'password_confirmation' => 'konfirmasi kata sandi',
        'nik' => 'NIK',
        'nip' => 'NIP',
        'alamat' => 'alamat',
        'alamat_detail' => 'detail alamat',
        'provinsi_id' => 'provinsi',
        'kabupaten_id' => 'kabupaten/kota',
        'kecamatan_id' => 'kecamatan',
        'kelurahan_id' => 'kelurahan',
        'jenis_kelamin' => 'jenis kelamin',
        'tanggal_lahir' => 'tanggal lahir',
        'agama' => 'agama',
        'pendidikan_terakhir' => 'pendidikan terakhir',
        'gelar' => 'gelar',
        'kampus' => 'kampus',
        'no_hp' => 'nomor HP',
        'status_perkawinan' => 'status perkawinan',
        'golongan_darah' => 'golongan darah',
        'foto_profil' => 'foto profil',
    ],
];

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Karyawan</title>
    <style>
        @page { margin: 16mm 12mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #0f172a; }
        h1 { font-size: 18px; margin: 0 0 8px 0; }
        .meta { font-size: 11px; color: #475569; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; }
        th { background: #e2e8f0; text-align: left; font-weight: 700; }
        tr:nth-child(even) td { background: #f8fafc; }
        .text-right { text-align: right; }
        .small { font-size: 10px; color: #64748b; }
        .header { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Karyawan</h1>
        <div class="small">Dibuat: {{ now()->format('d/m/Y H:i') }}</div>
    </div>
    <div class="meta">
        Filter: 
        @php $pairs = []; @endphp
        @foreach(($filters ?? []) as $k => $v)
            @if($v !== null && $v !== '')
                @php $pairs[] = $k . ': ' . $v; @endphp
            @endif
        @endforeach
        {{ implode(' | ', $pairs) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>JK</th>
                <th>HP</th>
                <th>Ruangan</th>
                <th>Profesi</th>
                <th>Status Pegawai</th>
                <th>Tgl Masuk</th>
                <th>Provinsi</th>
                <th>Kab/Kota</th>
                <th>Kecamatan</th>
                <th>Kelurahan</th>
                <th>Dokumen</th>
                <th>Kelengkapan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawan as $i => $k)
                @php
                    $tglMasuk = method_exists($k->tanggal_masuk_kerja, 'format') ? $k->tanggal_masuk_kerja->format('d/m/Y') : ($k->tanggal_masuk_kerja ?: '-');
                @endphp
                <tr>
                    <td class="text-right">{{ $i + 1 }}</td>
                    <td>{{ $k->nik ?: '-' }}</td>
                    <td>{{ $k->nip ?: '-' }}</td>
                    <td>{{ $k->user->name ?? '-' }}</td>
                    <td>{{ $k->user->email ?? '-' }}</td>
                    <td>{{ $k->jenis_kelamin ?: '-' }}</td>
                    <td>{{ $k->no_hp ?: '-' }}</td>
                    <td>{{ $k->ruangan->nama_ruangan ?? '-' }}</td>
                    <td>{{ $k->profesi->nama_profesi ?? '-' }}</td>
                    <td>{{ $k->statusPegawai->nama ?? '-' }}</td>
                    <td>{{ $tglMasuk }}</td>
                    <td>{{ $k->provinsi->name ?? '-' }}</td>
                    <td>{{ $k->kabupaten->name ?? '-' }}</td>
                    <td>{{ $k->kecamatan->name ?? '-' }}</td>
                    <td>{{ $k->kelurahan->name ?? '-' }}</td>
                    <td class="text-right">{{ $k->dokumen_count ?? 0 }}</td>
                    <td>{{ $k->status_kelengkapan ?: 'Belum Lengkap' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

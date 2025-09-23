<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Laporan Karyawan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        @page { size: A4 landscape; margin: 10mm; }
        body { font-family: ui-sans-serif, -apple-system, Segoe UI, Roboto, Helvetica, Arial, Noto Sans, sans-serif; color: #0f172a; }
        h1 { font-size: 20px; margin: 0 0 8px 0; }
        .meta { font-size: 12px; color: #475569; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; }
        th { background: #e2e8f0; text-align: left; font-weight: 700; }
        tr:nth-child(even) td { background: #f8fafc; }
        .text-right { text-align: right; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .btn { padding: 6px 10px; border: 1px solid #94a3b8; border-radius: 6px; background: #f1f5f9; color: #0f172a; text-decoration: none; }
        .btn:hover { background: #e2e8f0; }
    </style>
</head>
<body>
    <div class="toolbar no-print">
        <h1>Print Laporan Karyawan</h1>
        <div>
            <button class="btn" onclick="window.print()">Print</button>
            <a class="btn" href="{{ url()->previous() }}">Kembali</a>
        </div>
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

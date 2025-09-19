<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Karyawan - RSUD Dolopo</title>
    <style>
        /* F4 landscape: 330mm x 210mm */
        @page {
            size: 330mm 210mm;
            margin: 8mm; /* thin margins on all sides */
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Segoe UI', Roboto, Arial, 'Times New Roman', serif;
            font-size: 10px; /* compact but readable */
            line-height: 1.35;
            color: #000;
        }
        
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 5mm 8mm 3mm 8mm;
            border-bottom: 1px solid #000;
            background: #fff;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 11px;
            margin-bottom: 3px;
        }
        
        .content {
            margin-top: 26mm; /* slightly smaller header block */
            margin-bottom: 16mm; /* space for footer */
            padding-left: 4mm;  /* thin inner padding */
            padding-right: 4mm; /* thin inner padding */
        }
        
        .info-section h3 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-decoration: underline;
        }
        
        .filter-info {
            background-color: #f5f5f5;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        
        .filter-info p {
            margin-bottom: 5px;
            font-size: 11px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            table-layout: fixed; /* keep widths stable */
            font-size: 9px;
        }
        
        table, th, td {
            border: 1px solid #000;
        }
        
        th {
            background-color: #f0f0f0;
            padding: 6px 3px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }
        
        td {
            padding: 5px 3px;
            vertical-align: top;
            word-wrap: break-word;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #000;
            padding: 4mm 8mm;
            background: #fff;
        }
        
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin: 50px auto 10px auto;
        }
        
        .print-date {
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
        }
        
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .status-lengkap {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-belum {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <!-- Header Rumah Sakit (fixed) -->
    <div class="header">
        <h1>RSUD Dolopo</h1>
        <h2>Laporan Data Karyawan</h2>
    <p>Dicetak: {{ now()->setTimezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</p>
        @if(!empty(array_filter($filters ?? [])))
            <p>
                @if(!empty($filters['ruangan_id'])) Ruangan: {{ \App\Models\Ruangan::find($filters['ruangan_id'])->nama_ruangan ?? '-' }} | @endif
                @if(!empty($filters['profesi_id'])) Profesi: {{ \App\Models\Profesi::find($filters['profesi_id'])->nama_profesi ?? '-' }} | @endif
                @if(!empty($filters['status_pegawai_id'])) Status: {{ \App\Models\StatusPegawai::find($filters['status_pegawai_id'])->nama ?? '-' }} | @endif
                @if(!empty($filters['search'])) Cari: "{{ $filters['search'] }}" @endif
            </p>
        @endif
    </div>

    <div class="content">
        <!-- Ringkasan -->
        <div class="info-section" style="margin-bottom: 8px;">
            <p><strong>Total Karyawan:</strong> {{ $karyawan->count() }} | 
               <strong>Lengkap:</strong> {{ $karyawan->where('status_kelengkapan', 'Lengkap')->count() }} | 
               <strong>Belum:</strong> {{ $karyawan->where('status_kelengkapan', '!=', 'Lengkap')->count() }}</p>
        </div>
    
    <!-- Tabel Data Karyawan -->
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">NIK/NIP</th>
                <th width="14%">Nama & Kontak</th>
                <th width="25%">Alamat</th>
                <th width="18%">Unit & Profesi</th>
                <th width="12%">Status</th>
                <th width="6%">Dok</th>
            </tr>
        </thead>
        <tbody>
            @forelse($karyawan as $index => $k)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div><strong>{{ $k->nik ?: '-' }}</strong></div>
                        <div>{{ $k->nip ?: '-' }}</div>
                        <div>JK: {{ $k->jenis_kelamin === 'Laki-laki' ? 'L' : ($k->jenis_kelamin === 'Perempuan' ? 'P' : '-') }}</div>
                        <div>Tgl Lahir: {{ $k->tanggal_lahir ? (method_exists($k->tanggal_lahir, 'format') ? $k->tanggal_lahir->format('d/m/Y') : $k->tanggal_lahir) : '-' }}</div>
                    </td>
                    <td>
                        <div><strong>{{ $k->user->name ?? '-' }}</strong></div>
                        <div>{{ $k->user->email ?? '-' }}</div>
                        <div>HP: {{ $k->no_hp ?? '-' }}</div>
                    </td>
                    <td>
                        <div>{{ $k->alamat_detail ?? '-' }}</div>
                        <div>Kel: {{ $k->kelurahan->name ?? '-' }}, Kec: {{ $k->kecamatan->name ?? '-' }}</div>
                        <div>Kab/Kota: {{ $k->kabupaten->name ?? '-' }}, Prov: {{ $k->provinsi->name ?? '-' }}</div>
                    </td>
                    <td>
                        <div>Ruangan: {{ $k->ruangan->nama_ruangan ?? '-' }}</div>
                        <div>Profesi: {{ $k->profesi->nama_profesi ?? '-' }}</div>
                        <div>Agama: {{ $k->agama ?? '-' }}</div>
                        <div>Pendidikan: {{ $k->pendidikan_terakhir ?? '-' }}</div>
                        <div>Tgl Masuk: {{ $k->tanggal_masuk_kerja ? (method_exists($k->tanggal_masuk_kerja, 'format') ? $k->tanggal_masuk_kerja->format('d/m/Y') : $k->tanggal_masuk_kerja) : '-' }}</div>
                    </td>
                    <td>
                        <div>Status Pegawai: {{ $k->statusPegawai->nama ?? '-' }}</div>
                        <div>Kelengkapan: {{ $k->status_kelengkapan ?? 'Belum Lengkap' }}</div>
                    </td>
                    <td class="text-center">{{ $k->dokumen_count ?? ($k->dokumen->count() ?? 0) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data karyawan yang sesuai dengan filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <!-- Footer dan Tanda Tangan (fixed) -->
    <div class="footer">
        <div class="signature-section" style="display: flex; justify-content: space-between;">
            <div class="signature-box" style="width: 45%; text-align:center;">
                <p>Mengetahui,</p>
                <p><strong>Kepala RSUD Dolopo</strong></p>
                <div class="signature-line"></div>
                <p>(__________________)</p>
                <p>NIP: _______________</p>
            </div>
            
            <div class="signature-box" style="width: 45%; text-align:center;">
                <p>Dolopo, {{ now()->setTimezone('Asia/Jakarta')->format('d F Y') }}</p>
                <p><strong>Kepala Bagian SDM</strong></p>
                <div class="signature-line"></div>
                <p>(__________________)</p>
                <p>NIP: _______________</p>
            </div>
        </div>
        <div style="margin-top: 10px; text-align: center; font-size: 9px; color: #666;">
            <p>Dokumen ini dibuat otomatis oleh Sistem Informasi Karyawan RSUD Dolopo</p>
        </div>
    </div>
    
    <!-- Auto Print Script -->
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
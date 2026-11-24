<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Transmisi WhatsApp - UPTD Puskesmas Cilimus</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 30px; }
        .header { text-align: center; border-bottom: 2px solid #065f46; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; color: #065f46; text-transform: uppercase; }
        .header p { margin: 4px 0 0; font-size: 11px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; }
        th { background-color: #f0fdf4; color: #065f46; font-size: 11px; text-transform: uppercase; }
        .badge { padding: 2px 6px; border-radius: 4px; font-weight: bold; font-size: 10px; }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-danger { background: #ffe4e6; color: #9f1239; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #065f46; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            Cetak Dokumen
        </button>
    </div>

    <div class="header">
        <h1>UPTD Puskesmas Cilimus</h1>
        <p>Jl. Raya Cilimus No. 219, Kec. Cilimus, Kab. Kuningan, Jawa Barat 45556 | Telp: (0232) 8611118</p>
        <p><strong>Laporan Rekapitulasi Riwayat Pengiriman Reminder WhatsApp Pasien</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu Kirim</th>
                <th>Nama Pasien</th>
                <th>Nomor WhatsApp</th>
                <th>Status</th>
                <th>Keterangan Gateway</th>
                <th>Isi Pesan Terkirim</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $index => $log)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $log->waktu_kirim->format('d/m/Y H:i') }}</td>
                    <td><strong>{{ $log->reminder->nama_pasien ?? '-' }}</strong></td>
                    <td>{{ $log->reminder->nomor_wa ?? '-' }}</td>
                    <td style="text-align: center;">
                        <span class="badge {{ $log->status === 'berhasil' ? 'badge-success' : 'badge-danger' }}">
                            {{ strtoupper($log->status) }}
                        </span>
                    </td>
                    <td>{{ $log->keterangan }}</td>
                    <td style="font-size: 10px;">{{ $log->pesan_terkirim ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

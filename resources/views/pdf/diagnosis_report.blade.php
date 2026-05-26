<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil Diagnosa</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #009688; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #009688; }
        .content-table { w-full; border-collapse: collapse; margin-top: 20px; width: 100%; }
        .content-table th, .content-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .content-table th { background-color: #f2f2f2; width: 35%; }
        .footer { margin-top: 40px; font-size: 12px; color: #777; text-align: justify; }
        .img-container { text-align: center; margin-bottom: 20px; }
        .img-container img { max-width: 300px; max-height: 200px; border: 1px solid #ccc; }
    </style>
</head>
<body>

    <div class="header">
        <h1>EyeExpert</h1>
        <p>Sistem Asistensi Diagnosa Oftalmologi</p>
    </div>

    <div class="img-container">
        <img src="{{ public_path('storage/' . $diagnosis->image_path) }}" alt="Citra Mata">
    </div>

    <table class="content-table">
        <tr>
            <th>ID Pemeriksaan</th>
            <td>#EXM-{{ str_pad($diagnosis->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <th>Tanggal Pemeriksaan</th>
            <td>{{ $diagnosis->created_at->format('d F Y - H:i:s') }}</td>
        </tr>
        <tr>
            <th>Usia Pasien</th>
            <td>{{ $diagnosis->age }} Tahun</td>
        </tr>
        <tr>
            <th>Gejala Klinis Tercatat</th>
            <td>
                @php
                    $symptoms = json_decode($diagnosis->symptoms, true);
                @endphp
                @if(is_array($symptoms) && count($symptoms) > 0)
                    {{ implode(', ', array_map('ucfirst', str_replace('_', ' ', $symptoms))) }}
                @else
                    Tidak ada gejala spesifik yang dicentang.
                @endif
            </td>
        </tr>
        <tr>
            <th>Hasil Deteksi AI & Pakar</th>
            <td><strong>{{ $diagnosis->result }}</strong></td>
        </tr>
        <tr>
            <th>Tingkat Keyakinan (Confidence)</th>
            <td>{{ $diagnosis->confidence }}%</td>
        </tr>
    </table>

    <div class="footer">
        <strong>Disclaimer Medis:</strong> Hasil cetak ini dihasilkan oleh model Kecerdasan Buatan (AI) sebagai langkah skrining awal (deteksi dini) dan <strong>bukan</strong> merupakan vonis medis final. Harap konsultasikan hasil ini dengan dokter spesialis mata (Oftalmologis) untuk mendapatkan diagnosa klinis dan penanganan yang komprehensif.
    </div>

</body>
</html>
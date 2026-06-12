<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Diagnosa Eye Expert</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 18mm 16mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            line-height: 1.4;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        /* ===================== HEADER ===================== */
        .header-container {
            display: table;
            width: 100%;
            border-bottom: 3px solid #059669;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .header-left {
            display: table-cell;
            vertical-align: middle;
            text-align: left;
        }

        .header-right {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            width: 160px;
        }

        .header-left h1 {
            margin: 0;
            color: #059669;
            font-size: 22px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 800;
        }

        .header-left p {
            margin: 4px 0 0 0;
            color: #64748b;
            font-size: 11px;
            letter-spacing: 0.3px;
        }

        .doc-id-box {
            display: inline-block;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 6px;
            padding: 6px 12px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            font-weight: bold;
            color: #047857;
        }

        /* ===================== BANNER MODUL ===================== */
        .type-banner {
            text-align: center;
            margin-bottom: 18px;
            padding: 9px 12px;
            border-radius: 6px;
            background-color: #ecfdf5;
            border: 1px dashed #a7f3d0;
            color: #047857;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        /* ===================== SECTION TITLE ===================== */
        .section-title {
            font-size: 11px;
            font-weight: 800;
            color: #059669;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 18px 0 8px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* ===================== TABEL DATA PASIEN ===================== */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .content-table th,
        .content-table td {
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            font-size: 11.5px;
            text-align: left;
            vertical-align: middle;
        }

        .content-table th {
            background-color: #f8fafc;
            width: 38%;
            color: #475569;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.4px;
        }

        .content-table tr:nth-child(even) td {
            background-color: #fafafa;
        }

        /* ===================== CITRA KLINIS ===================== */
        .img-section {
            display: table;
            width: 100%;
            margin: 4px 0 0 0;
        }

        .img-cell {
            display: table-cell;
            width: 38%;
            vertical-align: middle;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-right: none;
            padding: 10px;
            background-color: #f8fafc;
        }

        .img-cell img {
            max-width: 100%;
            max-height: 140px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
        }

        .img-placeholder {
            font-size: 10px;
            color: #94a3b8;
            font-style: italic;
            padding: 30px 5px;
        }

        .img-caption {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 6px;
            font-style: italic;
        }

        .img-info-cell {
            display: table-cell;
            width: 62%;
            vertical-align: middle;
            border: 1px solid #e2e8f0;
        }

        .img-info-cell table {
            width: 100%;
            border-collapse: collapse;
        }

        .img-info-cell th,
        .img-info-cell td {
            border-bottom: 1px solid #e2e8f0;
            padding: 8px 12px;
            font-size: 11.5px;
            text-align: left;
        }

        .img-info-cell tr:last-child th,
        .img-info-cell tr:last-child td {
            border-bottom: none;
        }

        .img-info-cell th {
            background-color: #f8fafc;
            width: 45%;
            color: #475569;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.4px;
        }

        /* ===================== RINGKASAN HASIL ===================== */
        .result-summary {
            display: table;
            width: 100%;
            margin: 16px 0;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .result-cell {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 14px 8px;
            border-right: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .result-cell:last-child {
            border-right: none;
        }

        .result-cell .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            font-weight: bold;
            margin-bottom: 6px;
            display: block;
        }

        .result-cell .value {
            font-size: 16px;
            font-weight: 800;
            color: #1e293b;
        }

        .result-cell .value.green {
            color: #059669;
        }

        .status-banner {
            margin: 0 0 16px 0;
            padding: 12px 14px;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            text-align: center;
        }

        .status-banner .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #94a3b8;
            font-weight: bold;
            margin-bottom: 4px;
            display: block;
        }

        .status-banner .value {
            font-size: 14px;
            font-weight: 800;
            color: #047857;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* ===================== FOOTER ===================== */
        .footer {
            padding: 12px 14px;
            font-size: 10px;
            color: #64748b;
            text-align: justify;
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            border-radius: 0 6px 6px 0;
            line-height: 1.6;
        }

        .footer strong {
            color: #b45309;
        }

        .doc-meta {
            margin-top: 14px;
            text-align: right;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
    </style>
</head>
<body>

    @php
        $imagePath = $diagnosis->image_path
            ? public_path('storage/' . $diagnosis->image_path)
            : null;
        $imageExists = $imagePath && file_exists($imagePath);
    @endphp

    {{-- ===================== HEADER ===================== --}}
    <div class="header-container">
        <div class="header-left">
            <h1>Eye Expert System</h1>
            <p>Laporan Medis Analisis Visual &amp; Klasifikasi Patologi Mata</p>
        </div>
        <div class="header-right">
            <span class="doc-id-box">#EXM-{{ str_pad($diagnosis->id, 7, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    <div class="type-banner">
        Modul Pengujian: Klasifikasi Citra Mata berbasis Deep Learning (MobileNetV2)
    </div>

    {{-- ===================== DATA PASIEN ===================== --}}
    <div class="section-title">Data Identitas Pasien</div>
    <table class="content-table">
        <tbody>
            <tr>
                <th>Nama Pasien</th>
                <td style="text-transform: capitalize;">{{ $diagnosis->user->name ?? 'Pasien Tidak Diketahui' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $diagnosis->user->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $diagnosis->user->gender ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>
                    {{ $diagnosis->user->birth_place ?? '-' }},
                    {{ $diagnosis->user->birth_date ? \Carbon\Carbon::parse($diagnosis->user->birth_date)->locale('id')->translatedFormat('d F Y') : '-' }}
                </td>
            </tr>
            <tr>
                <th>Usia Pasien</th>
                <td>{{ $diagnosis->age }} Tahun</td>
            </tr>
            <tr>
                <th>Tanggal &amp; Waktu Analisis</th>
                <td>{{ \Carbon\Carbon::parse($diagnosis->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i:s') }} WIB</td>
            </tr>
        </tbody>
    </table>

    {{-- ===================== CITRA & RINGKASAN HASIL ===================== --}}
    <div class="section-title">Citra Klinis &amp; Ringkasan Hasil</div>

    <div class="img-section">
        <div class="img-cell">
            @if($imageExists)
                <img src="{{ $imagePath }}" alt="Citra Klinis Mata">
                <div class="img-caption">Citra Optik yang Dianalisis</div>
            @else
                <div class="img-placeholder">Citra tidak tersedia</div>
            @endif
        </div>
        <div class="img-info-cell">
            <table>
                <tr>
                    <th>Hasil Diagnosa AI</th>
                    <td style="font-weight: 800; color: #047857;">{{ strtoupper($diagnosis->result) }}</td>
                </tr>
                <tr>
                    <th>Tingkat Presisi Model</th>
                    <td style="font-weight: bold; color: #059669;">{{ $diagnosis->confidence }}% (Confidence Score)</td>
                </tr>
                <tr>
                    <th>Arsitektur Model</th>
                    <td>MobileNetV2 (Transfer Learning)</td>
                </tr>
                <tr>
                    <th>Resolusi Input Citra</th>
                    <td>224 &times; 224 piksel</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ===================== RINGKASAN SKOR ===================== --}}
    <div class="result-summary">
        <div class="result-cell">
            <span class="label">Hasil Diagnosa AI</span>
            <span class="value green">{{ strtoupper($diagnosis->result) }}</span>
        </div>
        <div class="result-cell">
            <span class="label">Tingkat Presisi Model</span>
            <span class="value green">{{ $diagnosis->confidence }}%</span>
        </div>
    </div>

    <div class="status-banner">
        <span class="label">Status Kesimpulan</span>
        <span class="value">{{ strtoupper($diagnosis->result) }}</span>
    </div>

    {{-- ===================== DISCLAIMER ===================== --}}
    <div class="footer">
        <strong>Pemberitahuan Medis:</strong> Dokumen ini merupakan hasil interpretasi awal (skrining) dari model Kecerdasan Buatan <em>(Artificial Intelligence)</em> berbasis pengenalan pola visual. Hasil ini bersifat probabilitas dan <strong>tidak dapat</strong> menggantikan vonis, diagnosis klinis final, maupun saran pengobatan dari Dokter Spesialis Mata (Oftalmologis). Pasien sangat disarankan untuk melakukan konsultasi medis secara langsung guna mendapatkan penanganan yang akurat dan komprehensif.
    </div>

    <div class="doc-meta">
        Dicetak pada: {{ now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y, H:i') }} WIB &middot; Dokumen Valid Eye Expert System
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Tes Refraksi Eye Expert</title>
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
            border-bottom: 3px solid #0891b2;
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
            color: #0891b2;
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
            background-color: #ecfeff;
            border: 1px solid #a5f3fc;
            border-radius: 6px;
            padding: 6px 12px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            font-weight: bold;
            color: #0e7490;
        }

        /* ===================== BANNER MODUL ===================== */
        .type-banner {
            text-align: center;
            margin-bottom: 18px;
            padding: 9px 12px;
            border-radius: 6px;
            background-color: #ecfeff;
            border: 1px dashed #67e8f9;
            color: #0e7490;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        /* ===================== SECTION TITLE ===================== */
        .section-title {
            font-size: 11px;
            font-weight: 800;
            color: #0891b2;
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

        .result-cell .value.cyan {
            color: #0891b2;
        }

        .status-banner {
            margin: 0 0 16px 0;
            padding: 12px 14px;
            background-color: #ecfeff;
            border: 1px solid #a5f3fc;
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
            color: #0e7490;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* ===================== KOTAK KESIMPULAN ===================== */
        .conclusion-box {
            padding: 14px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #0891b2;
            border-radius: 0 6px 6px 0;
            font-size: 11.5px;
            color: #334155;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .conclusion-box strong {
            display: block;
            margin-bottom: 6px;
            color: #0891b2;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

    {{-- ===================== HEADER ===================== --}}
    <div class="header-container">
        <div class="header-left">
            <h1>Eye Expert System</h1>
            <p>Laporan Hasil Tes Ketajaman Mata Refraksi Mandiri</p>
        </div>
        <div class="header-right">
            <span class="doc-id-box">#REF-{{ str_pad($refraction->id, 7, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    <div class="type-banner">
        Modul Pengujian: {{ $refraction->type === 'minus' ? 'Uji Jarak Jauh (Snellen Chart)' : 'Uji Baca Dekat (Jaeger Chart)' }}
    </div>

    {{-- ===================== DATA PASIEN ===================== --}}
    <div class="section-title">Data Identitas Pasien</div>
    <table class="content-table">
        <tbody>
            <tr>
                <th>Nama Pasien</th>
                <td style="text-transform: capitalize;">{{ $refraction->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $refraction->user->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $refraction->user->gender ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>
                    {{ $refraction->user->birth_place ?? '-' }},
                    {{ $refraction->user->birth_date ? \Carbon\Carbon::parse($refraction->user->birth_date)->locale('id')->translatedFormat('d F Y') : '-' }}
                </td>
            </tr>
            <tr>
                <th>Usia Pasien</th>
                <td>{{ $refraction->user->birth_date ? \Carbon\Carbon::parse($refraction->user->birth_date)->age . ' Tahun' : '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal &amp; Waktu Tes</th>
                <td>{{ \Carbon\Carbon::parse($refraction->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y - H:i:s') }} WIB</td>
            </tr>
        </tbody>
    </table>

    {{-- ===================== RINGKASAN HASIL ===================== --}}
    <div class="section-title">Ringkasan Hasil Pengujian</div>

    <div class="result-summary">
        <div class="result-cell">
            <span class="label">Skor Ketajaman Visual</span>
            <span class="value cyan">{{ strtoupper($refraction->va_score) }}</span>
        </div>
        <div class="result-cell">
            <span class="label">Skor Konversi</span>
            <span class="value cyan">{{ $refraction->confidence }}%</span>
        </div>
    </div>

    <div class="status-banner">
        <span class="label">Jenis Modul Pengujian</span>
        <span class="value">{{ $refraction->type === 'minus' ? 'Uji Jarak Jauh (Minus dan Plus)' : 'Uji Baca Dekat (Plus)' }}</span>
    </div>

    {{-- ===================== INDIKASI KLINIS ===================== --}}
    <div class="conclusion-box">
        <strong>Indikasi Klinis Refraksi</strong>
        {{ $refraction->conclusion }}
    </div>

    {{-- ===================== DISCLAIMER ===================== --}}
    <div class="footer">
        <strong>Pemberitahuan Medis:</strong> Dokumen ini merupakan hasil skrining ketajaman visual mandiri yang dilakukan oleh pasien sendiri menggunakan perangkat digital. Hasil ini bersifat estimasi awal dan <strong>tidak dapat</strong> menggantikan pemeriksaan refraksi klinis (refraktometri) maupun resep kacamata dari Dokter Spesialis Mata atau Optometris berlisensi. Pasien sangat disarankan untuk melakukan pemeriksaan langsung di Optik atau klinik mata terdekat untuk mendapatkan ukuran lensa yang akurat.
    </div>

    <div class="doc-meta">
        Dicetak pada: {{ now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y, H:i') }} WIB &middot; Dokumen Valid Eye Expert System
    </div>

</body>
</html>
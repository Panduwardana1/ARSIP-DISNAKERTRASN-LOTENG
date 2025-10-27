<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Rekomendasi {{ $rekom->nomor }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 25mm 25mm 20mm 25mm;
        }

        @page cover {
            size: A4 portrait;
            margin: 25mm 25mm 20mm 25mm;
        }

        @page landscape {
            size: A4 landscape;
            margin: 15mm 20mm 15mm 20mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            color: #000;
            line-height: 1.45;
            margin: 0;
        }

        h1,
        h2,
        h3 {
            margin: 0;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 10.5pt;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 5px 7px;
            vertical-align: top;
            word-break: break-word;
        }

        thead {
            display: table-header-group;
        }

        thead th {
            background: #f3f3f3;
            text-transform: uppercase;
            font-size: 10pt;
            letter-spacing: 0.4pt;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .cover-page {
            page: cover;
        }

        .landscape-page {
            page: landscape;
        }

        .brand {
            text-align: center;
        }

        .brand h1 {
            font-size: 18pt;
            text-transform: uppercase;
            letter-spacing: 0.6pt;
        }

        .brand h2 {
            font-size: 14pt;
            margin-top: 6px;
            text-transform: uppercase;
        }

        .brand p {
            margin-top: 6px;
            font-size: 11pt;
        }

        .brand hr {
            border: 0;
            border-top: 3px double #000;
            margin: 16px 0 20px;
        }

        .letter-date {
            text-align: right;
            font-size: 11pt;
            margin-bottom: 16px;
        }

        .letter-meta {
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
            margin-bottom: 16px;
        }

        .letter-meta td {
            padding: 3px 6px;
            vertical-align: top;
        }

        .letter-meta td:first-child {
            width: 130px;
            font-weight: 600;
        }

        .letter-meta td:nth-child(2) {
            width: 12px;
        }

        .letter-body {
            text-align: justify;
            margin-top: 12px;
        }

        .letter-body p {
            margin: 0 0 12px;
            text-indent: 24px;
        }

        .letter-body p.salutation,
        .letter-body p.closing {
            text-indent: 0;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
            font-size: 11pt;
        }

        .signature .position {
            text-transform: uppercase;
            font-weight: 600;
        }

        .signature .name {
            font-weight: 700;
            text-decoration: underline;
        }

        .report-header {
            text-align: center;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .report-header h2 {
            font-size: 16pt;
            letter-spacing: 0.8pt;
        }

        .report-header p {
            margin-top: 4px;
            font-size: 10pt;
            text-transform: none;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 10.5pt;
        }

        .meta-table td {
            padding: 2px 0;
        }

        .meta-table td:first-child {
            width: 180px;
            font-weight: 600;
        }

        .meta-table td:nth-child(2) {
            width: 12px;
        }

        .cell-identitas strong {
            display: block;
            font-size: 11pt;
        }

        .cell-identitas span,
        .cell-identitas small {
            display: block;
        }

        .cell-identitas small {
            color: #555;
            font-size: 9pt;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    {{-- Halaman 1 - Surat --}}
    <section class="cover cover-page">
        <div class="brand">
            <h1>Pemerintah Kabupaten Kudus</h1>
            <h2>Dinas Tenaga Kerja, Perindustrian, Koperasi dan UKM</h2>
            <p>Jl. Mejobo No. 99 Kudus &middot; Telp (0291) 123456 &middot; email: disnaker@kuduskab.go.id</p>
            <hr>
        </div>

        <div class="letter-date">Kudus, {{ $tanggal }}</div>

        <table class="letter-meta">
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td>{{ $rekom->nomor }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td><strong>Rekomendasi Pengurusan Paspor</strong></td>
            </tr>
        </table>

        <div style="text-align: left; margin-top: 12px;">
            Kepada Yth.<br>
            Kepala Kantor Imigrasi ____________________<br>
            di tempat
        </div>

        <div class="letter-body">
            <p class="salutation">Dengan hormat,</p>
            <p>Bersama ini kami mengajukan permohonan rekomendasi penerbitan paspor bagi calon pekerja migran
                Indonesia sebagaimana tercantum pada lampiran. Seluruh data telah kami verifikasi sesuai ketentuan dan
                dapat dipergunakan sebagai bahan pengurusan lebih lanjut.</p>
            <p class="closing">Demikian disampaikan, atas perhatian dan kerja samanya kami ucapkan terima kasih.</p>
        </div>

        <div class="signature">
            Hormat kami,<br>
            <span class="position">Kepala Dinas</span><br><br><br>
            <span class="name">___________________________</span><br>
            NIP. _______________________
        </div>
    </section>

    <div class="page-break"></div>

    {{-- Halaman 2 dan seterusnya - Data Landscape --}}
    @foreach ($pages as $pageIndex => $rows)
        <section class="landscape-page">
            <div class="report-header">
                <h2>Daftar Rekomendasi Paspor</h2>
                <p>Nomor: {{ $rekom->nomor }}</p>
            </div>

            @if ($loop->first)
                <table class="meta-table">
                    <tr>
                        <td>Tanggal Rekomendasi</td>
                        <td>:</td>
                        <td>{{ $tanggal }}</td>
                    </tr>
                    <tr>
                        <td>Total Peserta</td>
                        <td>:</td>
                        <td>{{ $rekom->total }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Laki-laki</td>
                        <td>:</td>
                        <td>{{ $rekom->jumlah_laki }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Perempuan</td>
                        <td>:</td>
                        <td>{{ $rekom->jumlah_perempuan }}</td>
                    </tr>
                </table>
            @endif

            @php
                $offset = $pages->take($pageIndex)->sum(fn($page) => $page->count());
            @endphp

            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 23%;">Identitas</th>
                        <th style="width: 8%;">Gender</th>
                        <th style="width: 12%;">Pendidikan</th>
                        <th style="width: 16%;">Perusahaan</th>
                        <th style="width: 16%;">Agensi</th>
                        <th style="width: 10%;">Destinasi</th>
                        <th style="width: 10%;">Lowongan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $rowIndex => $row)
                        <tr>
                            <td style="text-align: center;">{{ $offset + $rowIndex + 1 }}</td>
                            <td class="cell-identitas">
                                <strong>{{ $row['nama'] }}</strong>
                                <span>{{ $row['nik'] }}</span>
                                <small>{{ $row['alamat'] }}</small>
                            </td>
                            <td style="text-align: center;">{{ $row['gender'] }}</td>
                            <td>{{ $row['pendidikan'] ?? '-' }}</td>
                            <td>{{ $row['perusahaan'] ?? '-' }}</td>
                            <td>{{ $row['agensi'] ?? '-' }}</td>
                            <td>{{ $row['destinasi'] ?? '-' }}</td>
                            <td>{{ $row['pekerjaan'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>

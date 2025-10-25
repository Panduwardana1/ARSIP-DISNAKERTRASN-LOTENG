<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Rekomendasi {{ $rekom->nomor }}</title>
    <style>
        @page {
            size: A4 landscape;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 4px;
        }

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

        .cover-page {
            page: cover;
        }

        .landscape-page {
            page: landscape;
            rotate: 90deg;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #000;
        }

        h1,
        h2 {
            margin: 0;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5pt;
            table-layout: fixed;
            word-wrap: break-word;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 5px 7px;
            vertical-align: top;
        }

        thead th {
            background: #f0f0f0;
            text-transform: uppercase;
            font-size: 10pt;
        }

        .page-break {
            page-break-after: always;
        }

        /* Cover styling */

        .cover {
            text-align: center;
        }

        .cover .brand h1 {
            font-size: 18pt;
            margin-bottom: 4px;
        }

        .cover .letter-meta td {
            padding: 3px 6px;
            font-size: 11pt;
        }

        .header {
            text-align: center;
            margin-bottom: 14px;
            text-transform: uppercase;
        }

        .meta {
            margin-bottom: 16px;
            font-size: 11pt;
        }

        .meta td {
            padding: 2px 4px;
        }

        .cell-identitas strong {
            display: block;
            font-size: 10.5px;
        }

        .cell-identitas span {
            display: block;
        }

        .cell-identitas small {
            display: block;
            color: #555;
            font-size: 9px;
        }
    </style>
</head>

<body>
    {{-- Halaman 1 - Surat --}}
    <div class="cover cover-page">
        <div class="brand">
            <h1>Pemerintah Kabupaten Kudus</h1>
            <h2>Dinas Tenaga Kerja, Perindustrian, Koperasi dan UKM</h2>
            <p>Jl. Mejobo No. 99 Kudus &middot; Telp (0291) 123456 &middot; email: disnaker@kuduskab.go.id</p>
            <hr>
        </div>

        <div style="text-align:right;">Kudus, ____________________</div>

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

        <p style="margin-top:20px;">Kepada Yth.<br>Kepala Kantor Imigrasi ____________________<br>di tempat</p>

        <p style="text-align:justify;">Dengan hormat,<br>
            Bersama ini kami mengajukan permohonan rekomendasi penerbitan paspor bagi calon pekerja migran Indonesia
            sebagaimana tercantum pada lampiran.</p>

        <div style="margin-top:40px; text-align:right;">
            Hormat kami,<br>
            <strong>Kepala Dinas</strong><br><br><br>
            <u>____________________</u><br>
            NIP. __________________
        </div>
    </div>

    <div class="page-break"></div>

    {{-- Halaman 2 dan seterusnya - Data Landscape --}}
    @foreach ($pages as $pageIndex => $rows)
        <div class="landscape-page">
            <div class="header">
                <h2>Rekomendasi Paspor</h2>
                <p>Nomor: {{ $rekom->nomor }}</p>
            </div>

            @if ($loop->first)
                <table class="meta">
                    <tr>
                        <td>Tanggal Rekomendasi</td>
                        <td>: {{ $tanggal }}</td>
                    </tr>
                    <tr>
                        <td>Total Peserta</td>
                        <td>: {{ $rekom->total }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Laki-laki</td>
                        <td>: {{ $rekom->jumlah_laki }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Perempuan</td>
                        <td>: {{ $rekom->jumlah_perempuan }}</td>
                    </tr>
                </table>
            @endif

            @php
                $offset = $pages->take($pageIndex)->sum(fn($page) => $page->count());
            @endphp
            <table>
                <thead>
                    <tr>
                        <th style="width:5px;">No</th>
                        <th style="width:auto;">Identitas</th>
                        <th style="width:55px;">Gender</th>
                        <th style="width:110px;">Pendidikan</th>
                        <th style="width:140px;">Perusahaan</th>
                        <th style="width:140px;">Agensi</th>
                        <th style="width:110px;">Destinasi</th>
                        <th style="width:140px;">Lowongan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $rowIndex => $row)
                        <tr>
                            <td style="text-align:center;">{{ $offset + $rowIndex + 1 }}</td>
                            <td class="cell-identitas">
                                <strong>{{ $row['nama'] }}</strong>
                                <span>{{ $row['nik'] }}</span>
                                <small>{{ $row['alamat'] }}</small>
                            </td>
                            <td>{{ $row['gender'] }}</td>
                            <td>{{ $row['pendidikan'] ?? '-' }}</td>
                            <td>{{ $row['perusahaan'] ?? '-' }}</td>
                            <td>{{ $row['agensi'] ?? '-' }}</td>
                            <td>{{ $row['destinasi'] ?? '-' }}</td>
                            <td>{{ $row['pekerjaan'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>

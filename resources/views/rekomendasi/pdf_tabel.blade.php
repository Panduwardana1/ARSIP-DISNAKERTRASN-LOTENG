<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Data Rekomendasi {{ $rekom->nomor }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm 20mm 15mm 20mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 10.5pt;
            color: #000;
            line-height: 1.4;
            margin: 0;
        }

        h2,
        h3 {
            margin: 0;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 10pt;
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
            font-size: 9.5pt;
            letter-spacing: 0.4pt;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .report-header {
            text-align: center;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .report-header h2 {
            font-size: 15pt;
            letter-spacing: 0.6pt;
        }

        .report-header p {
            margin-top: 4px;
            font-size: 10pt;
            text-transform: none;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
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

        .signature {
            margin-top: 24px;
            text-align: right;
            font-size: 10.5pt;
        }

        .signature p {
            margin: 0;
        }

        .signature .position {
            text-transform: uppercase;
            font-weight: 600;
        }

        .signature .name {
            margin-top: 60px;
            font-weight: 700;
            text-decoration: underline;
        }

        .signature .nip {
            margin-top: 4px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    @foreach ($pages as $pageIndex => $rows)
        <section class="table-page">
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

            @if ($loop->last)
                <div class="signature">
                    <p>Kudus, {{ $tanggal }}</p>
                    <p class="position">Kepala Dinas</p>
                    <p class="name">___________________________</p>
                    <p class="nip">NIP. _______________________</p>
                </div>
            @endif
        </section>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>

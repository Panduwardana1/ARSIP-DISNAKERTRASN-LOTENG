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
        }

        h2 {
            margin: 0 0 6px;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .meta {
            margin-bottom: 16px;
            font-size: 11pt;
        }

        .meta td {
            padding: 2px 4px;
        }

        .meta td:first-child {
            min-width: 160px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 5px 6px;
            vertical-align: top;
        }

        thead th {
            background: #f0f0f0;
            text-transform: uppercase;
            font-size: 10pt;
        }

        .cell-identitas strong {
            display: block;
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
    @foreach ($pages as $pageIndex => $rows)
        <div class="table-page">
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
                        <th style="width: 40px;">No</th>
                        <th style="width: 170px;">Identitas</th>
                        <th style="width: 60px;">Gender</th>
                        <th style="width: 120px;">Pendidikan</th>
                        <th style="width: 160px;">Perusahaan</th>
                        <th style="width: 160px;">Agensi</th>
                        <th style="width: 120px;">Destinasi</th>
                        <th style="width: 160px;">Lowongan</th>
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
            <div>
                <span>PIMPINAN DINSA PENEMPATAN </span>
                <DIV>
                    Tanda tangan anda disini
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequatur similique quos facere.
                    Aspernatur animi reprehenderit est amet incidunt voluptatibus tempora.
                </DIV>
                <span>
                    <p>UPIANDI S.Sos</p>
                    <p>NIM : 29139847612421648</p>
                </span>
            </div>

            @if (!$loop->last)
                <div class="page-break"></div>
        </div>
    @endif
    @endforeach
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Daftar Calon PMI - {{ $rekom->nomor }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm 20mm 15mm 20mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #000;
            line-height: 1.4;
            margin: 0;
        }

        h2 {
            text-transform: uppercase;
            font-size: 14pt;
            text-align: center;
            margin-bottom: 14px;
        }

        p,
        td,
        th {
            font-size: 10pt;
        }

        .meta {
            margin-bottom: 10px;
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        .heade-row {
            margin-right: 5rem;
        }

        .meta td {
            padding: 3px 0;
            vertical-align: top;
        }

        .meta td.meta-label {
            width: 160px;
            font-weight: bold;
            white-space: nowrap;
        }

        .meta td.meta-separator {
            width: 25px;
            text-align: center;
            white-space: nowrap;
        }

        .meta td.meta-value {
            padding-left: 16px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th,
        table.data td {
            border: 1px solid #444;
            padding: 5px 6px;
            vertical-align: middle;
        }

        table.data th {
            background: #f3f3f3;
            font-weight: bold;
            text-align: center;
        }

        .identitas strong {
            display: block;
            font-size: 10.5pt;
        }

        .identitas span {
            display: block;
            font-size: 9pt;
        }

        .identitas small {
            display: block;
            color: #555;
            font-size: 8.5pt;
        }

        .signature-block {
            width: 90%;
            padding-left: 8cm;
            margin-top: 60px;
            text-align: center;
        }

        .signature-block .position {
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            line-height: 1.4;
        }

        .signature-block .space {
            height: 90px;
        }

        .signature-block .name {
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .signature-block .name u {
            text-decoration: underline;
        }

        .signature-block .nip {
            margin: 0;
        }
    </style>
</head>

<body>
    @php
        $pages = collect($pages ?? []);
        $rows = $pages->flatten(1);
        $firstRow = $rows->first();
        $countRow = $rows->count();
        $destinasiLabel = ($destinasi ?? null) && ($destinasi ?? null) !== '-' ? $destinasi : ($firstRow['destinasi'] ?? '-');
    @endphp
    <h2>DAFTAR CALON PMI HASIL VERIFIKASI DOKUMEN</h2>

    {{-- Tabel Informasi P3MI --}}
    <table class="meta">
        <tr>
            <td class="meta-label">Nama PJTKI</td>
            <td class="meta-separator">:</td>
            <td class="meta-value">{{ optional($rekom->perusahaan)->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Negara Tujuan</td>
            <td class="meta-separator">:</td>
            <td class="meta-value">{{ $destinasiLabel }}</td>
        </tr>
        <tr>
            <td class="meta-label">No. Rekomendasi Paspor</td>
            <td class="meta-separator">:</td>
            <td style="word-spacing: 48px;">562/ LTSA/</td>
        </tr>
        <tr>
            <td class="meta-label">Tgl. Rekomendasi Paspor</td>
            <td class="meta-separator">:</td>
            <td class="meta-value">{{ $tanggal ?? '-' }}</td>
        </tr>
    </table>

    <h4 style="font-weight: bold;">DISNAKERTRANS KAB. LOMBOK TENGAH</h4>

    {{-- Tabel data PMI --}}
    <table class="data">
        <thead>
            <tr>
                <th style="width:4%;">No</th>
                <th style="width:18%;">Nama &amp; ID PMI</th>
                <th style="width:14%;">Tempat / Tgl. Lahir</th>
                <th style="width:5%;">L/P</th>
                <th style="width:20%;">Alamat PMI</th>
                <th style="width:15%;">Agency</th>
                <th style="width:14%;">Jenis Pekerjaan</th>
                <th style="width:10%;">Pendidikan</th>
            </tr>
        </thead>
        <tbody>
            @php $rowNumber = 1; @endphp
            @forelse ($pages as $page)
                @foreach ($page as $row)
                    <tr>
                        <td style="text-align:center;">{{ $rowNumber++ }}</td>
                        <td class="identitas">
                            <strong>{{ $row['nama'] ?? '-' }}</strong>
                            <span>{{ $row['nik'] ?? '-' }}</span>
                        </td>
                        <td>{{ $row['tempat_lahir'] ?? '-' }}, {{ $row['tanggal_lahir'] ?? '-' }}</td>
                        <td style="text-align:center;">{{ $row['gender'] ?? '-' }}</td>
                        <td>{{ $row['alamat'] ?? '-' }}</td>
                        <td>{{ $row['agensi'] ?? '-' }}</td>
                        <td>{{ $row['pekerjaan'] ?? '-' }}</td>
                        <td>{{ $row['pendidikan'] ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <span>Jumlah yang disetujui {{  $countRow }}</span>

    {{-- Tanda tangan --}}
    <div class="signature-block">
        <p class="position">A.N. Kepala Disnakertrans Kab. Lombok Tengah</p>
        <p class="position">Kabid Penempatan dan Perluasan Kerja</p>
        <div class="space"></div>
        <p class="name"><u>SUPIANDI, S.STP</u></p>
        <p class="nip">NIP 198201182002121001</p>
    </div>
</body>

</html>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Lampiran Rekomendasi</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 12mm 14mm;
        }

        @font-face {
            font-family: 'Arial';
            font-style: normal;
            font-weight: 400;
            src: url("{{ public_path('asset/fonts/arial.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'Arial';
            font-style: normal;
            font-weight: 600;
            src: url("{{ public_path('asset/fonts/arialmd.ttf') }}") format('truetype');
        }

        body {
            font-family: 'Arial', Arial, sans-serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.35;
            margin: 0;
            font-weight: 400;
        }

        body * {
            font-family: 'Arial', Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .page-title {
            text-align: center;
            font-size: 20pt;
            font-weight: 600;
            letter-spacing: 0.02em;
            margin: 0 0 22px 0;
        }

        .meta-table {
            width: auto;
            margin-bottom: 24px;
        }

        .meta-table td {
            border: none;
            padding: 2px 6px 2px 0;
            font-size: 11pt;
            line-height: 1;
        }

        .meta-label {
            width: 200px;
        }

        .section-title {
            font-weight: 600;
            font-size: 13pt;
            margin: 10px 0 8px 0;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
        }

        thead {
            background: #f3f3f3;
            font-weight: 600;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-row-group;
        }

        tr {
            page-break-inside: avoid;
        }

        .summary {
            margin-bottom: 6px;
        }

        .bold {
            font-weight: 600;
        }

        .approvals {
            display: inline-block;
            margin-top: 4px;
            font-size: 9pt;
            font-weight: 400;
        }

        .signature-block {
            width: 50%;
            margin-left: 32rem;
            margin-top: 50px;
            font-weight: 400;
            text-align: center;
            font-size: 12pt;
        }

        .signature-block .position {
            font-weight: 600;
            text-transform: uppercase;
            margin: 0;
            line-height: 0%;
        }

        .signature-block .space {
            height: 90px;
        }

        .author {
            text-align: center;
            line-height: 1.2;
        }

        .name {
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            display: block;
        }

        .nip {
            margin: 0;
            display: block;
            font-weight: bold;
        }

        .signature-block .name {
            font-weight: 600;
            text-transform: uppercase;
            margin: 0;
        }

        .signature-block .nip {
            margin: 0;
        }

        .table-wrapper {
            margin-top: 8px;
            font-size: 13px;
            line-height: 1;
        }
    </style>
</head>

<body>

    @php
        $perusahaanNames = $rekomendasi->items->pluck('perusahaan.nama')->filter()->unique();
        if ($perusahaanNames->isEmpty()) {
            $perusahaanNames = $rekomendasi->tenagaKerjas->pluck('perusahaan.nama')->filter()->unique();
        }

        $negaraNames = $rekomendasi->items->pluck('negara.nama')->filter()->unique();
        if ($negaraNames->isEmpty()) {
            $negaraNames = $rekomendasi->tenagaKerjas->pluck('negara.nama')->filter()->unique();
        }
        $author = $rekomendasi->author;
        $authorLine = $author
            ? trim($author->nama . ($author->jabatan ? ' - ' . $author->jabatan : ''))
            : 'A.N. Kepala Disnakertrans';
    @endphp

    <h1 class="page-title">DAFTAR CALON PMI HASIL VERIFIKASI DOKUMEN</h1>

    <table class="meta-table summary">
        <tr>
            <td class="meta-label">Nama PJTKI</td>
            <td style="width: 10px;">:</td>
            <td>{{ $perusahaanNames->isNotEmpty() ? $perusahaanNames->implode(', ') : '-' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Negara Tujuan</td>
            <td>:</td>
            <td>{{ $negaraNames->isNotEmpty() ? $negaraNames->implode(', ') : '-' }}</td>
        </tr>
        <tr>
            <td class="meta-label">No. Rekomendasi Paspor</td>
            <td>:</td>
            <td><span style="font-weight: 600;">{{ $rekomendasi->kode }}</span></td>
        </tr>
        <tr>
            <td class="meta-label">Tgl. Rekomendasi Paspor</td>
            <td>:</td>
            <td>{{ $stats['tanggal'] }}</td>
        </tr>
    </table>

    <div class="section-title">DISNAKERTRANS KAB. LOMBOK TENGAH</div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:30px; font-weight: 600; line-height: 1;">NO</th>
                    <th style="width:180px; font-weight: 600; line-height: 1;">Nama & ID PMI</th>
                    <th style="width:70px; font-weight: 600; line-height: 1;">Tempat <br> Tgl. Lahir</th>
                    <th style="width:6px; font-weight: 600; line-height: 1;">L/P</th>
                    <th style="width:220px; font-weight: 600; line-height: 1;">Alamat PMI</th>
                    <th style="width:70px; font-weight: 600; line-height: 1;">Agency</th>
                    <th style="width:70px; font-weight: 600; line-height: 1;">Jenis Pekerjaan</th>
                    <th style="width:7px; font-weight: 600; line-height: 1;">Pendidikan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekomendasi->tenagaKerjas as $i => $tk)
                    @php
                        $gender = strtoupper(substr($tk->gender ?? '-', 0, 1));
                        $tempatLahir = $tk->tempat_lahir ?: '-';
                        $tanggalLahir = optional($tk->tanggal_lahir)->translatedFormat('d F Y');
                        $alamatLengkap = $tk->alamat_lengkap ?: '-';
                        $agency = optional($tk->agency)->nama ?? '-';
                        $jenisPekerjaan = optional($tk->agency)->lowongan ?? '-';
                        $pendidikan = optional($tk->pendidikan)->nama ?? '-';
                    @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div class="bold">{{ $tk->nama }}</div>
                            {{ $tk->nik }}<br>
                            @if (!empty($tk->alamat))
                                <strong>{{ $tk->alamat }}</strong>
                            @endif
                        </td>
                        <td>
                            {{ $tempatLahir }}
                            {{ $tanggalLahir }}
                        </td>
                        <td>{{ $gender }}</td>
                        <td>{{ $alamatLengkap }}</td>
                        <td>{{ $agency }}</td>
                        <td>{{ $jenisPekerjaan }}</td>
                        <td>{{ $pendidikan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <strong class="approvals">Jumlah yang disetujui {{ $stats['total'] }}</strong>

    <div class="signature-block">
        @if ($author)
            <strong class="position">{{ strtoupper($author->jabatan) }}</strong>
            <div class="space"></div>

            <div class="author">
                <strong class="name"><u>{{ strtoupper($author->nama) }}</u></strong>
                <strong class="nip">NIP {{ $author->nip ?? '-' }}</strong>
            </div>
        @else
            <strong class="position">A.N. KEPALA DISNAKERTRANS KAB. LOMBOK TENGAH</strong>
            <strong class="position">KABID PENEMPATAN DAN PERLUASAN KERJA</strong>
            <div class="space"></div>

            <div class="author">
                <strong class="nip">NIP 198201182002121001</strong>
            </div>
            <strong class="name"><u>SUPIANDI, S.STP</u></strong>
        @endif
    </div>
</body>

</html>

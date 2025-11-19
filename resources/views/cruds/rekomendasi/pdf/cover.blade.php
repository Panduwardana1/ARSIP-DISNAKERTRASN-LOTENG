<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Surat Rekomendasi Paspor PMI</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 30mm 25mm 30mm;
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

        strong,
        b {
            font-weight: 600;
        }

        .page {
            width: 100%;
        }

        .kop-table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-family: Arial, sans-serif;
        }

        .kop-table td {
            vertical-align: middle;
            padding: 0;
            margin: 0;
            line-height: 0.8;
        }

        .kop-logo img {
            height: 75px;
            width: 78px;
        }

        .kop-text {
            text-align: center;
            line-height: 1.1;
        }

        .kop-title-1 {
            font-size: 15pt;
            font-weight: 400;
            margin: 0;
            letter-spacing: -0.5px;
            font-family: 'Arial';
        }

        .kop-title-2 {
            font-size: 16pt;
            font-weight: 600;
            margin: 2px 0 4px 0;
            letter-spacing: -0.5px;
            font-family: 'Arial';
        }

        .kop-address {
            font-size: 10pt;
            margin: 0;
            margin-top: 4px;
            font-family: 'Arial';
        }

        .divider {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            margin: 6px 0 8px;
        }

        .tujuan {
            padding-bottom: 1rem;
            font-weight: 400;
            font-size: 12pt
        }

        .meta {
            width: 100%;
            font-size: 12pt;
            line-height: 1;
        }

        .meta td {
            vertical-align: top;
        }

        .meta td:first-child {
            width: 100px;
        }

        .meta td:nth-child(2) {
            width: 15px;
            text-align: right;
        }

        .perihal-text {
            padding: 0;
            display: block;
            width: 100%;
            line-height: 1.1;
            text-indent: 0;
        }

        .perihal-text span {
            display: block;
            margin-left: 3px;
        }

        .date {
            text-align: right;
            margin-bottom: 14px;
        }

        .content {
            font-size: 12pt;
            text-align: left;
            line-height: 1;
        }

        .signature-block {
            width: 80%;
            margin-left: 9rem;
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
    </style>
</head>

<body>
    <div class="page">
        @php
            $perusahaanList = $rekomendasi->items
                ->map(fn($item) => optional($item->perusahaan)->nama)
                ->filter()
                ->unique()
                ->values();

            if ($perusahaanList->isEmpty()) {
                $perusahaanList = $rekomendasi->tenagaKerjas
                    ->map(fn($tk) => optional($tk->perusahaan)->nama)
                    ->filter()
                    ->unique()
                    ->values();
            }

            $negaraList = $rekomendasi->items
                ->map(fn($item) => optional($item->negara)->nama)
                ->filter()
                ->unique()
                ->values();

            if ($negaraList->isEmpty()) {
                $negaraList = $rekomendasi->tenagaKerjas
                    ->map(fn($tk) => optional($tk->negara)->nama)
                    ->filter()
                    ->unique()
                    ->values();
            }

            $perusahaanName = $perusahaanList->isNotEmpty() ? $perusahaanList->implode(', ') : '-';
            $destinasiTujuan = $negaraList->isNotEmpty() ? $negaraList->implode(', ') : '-';

            $nomorRekom = $rekomendasi->kode ?? '-';
            $totalCpmi = $stats['total'] ?? ($rekomendasi->total ?? $rekomendasi->tenagaKerjas->count());
            $jumlahLaki = $stats['laki'] ?? 0;
            $jumlahPerempuan = $stats['perempuan'] ?? 0;

            $tanggalCetak =
                optional($rekomendasi->tanggal)->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y');
            $author = $rekomendasi->author;

            try {
                $formatter = class_exists(\NumberFormatter::class)
                    ? new \NumberFormatter('id_ID', \NumberFormatter::SPELLOUT)
                    : null;
            } catch (\Throwable $e) {
                $formatter = null;
            }

            $spellNumber = function ($value) use ($formatter) {
                if (!is_numeric($value) || $formatter === null) {
                    return null;
                }

                $spelled = $formatter->format($value);
                if (!is_string($spelled)) {
                    return null;
                }

                $spelled = trim(mb_strtolower($spelled, 'UTF-8'));

                return $spelled !== '' ? $spelled : null;
            };

            $totalCpmiSpelled = $spellNumber($totalCpmi);
            $logoPath = public_path('asset/images/lombok_tengah2.png');
            $logoData = file_exists($logoPath)
                ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
                : null;
        @endphp

        <table class="kop-table">
            <tr>
                <td style="width:110px;" class="kop-logo">
                    <img src="{{ $logoData }}" alt="Logo Kabupaten Lombok Tengah">
                </td>

                <td class="kop-text">
                    <div class="kop-title-1">PEMERINTAH KABUPATEN LOMBOK TENGAH</div>
                    <div class="kop-title-2">DINAS TENAGA KERJA DAN TRANSMIGRASI</div>
                    <div class="kop-address">
                        Alamat : Jl. S. Parman No. 5 Telepon (0370) 653130, Praya 83511
                    </div>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="date">
            Lombok Tengah, {{ $tanggalCetak }}
        </div>

        <table class="meta">
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td style="word-spacing: 4px;">{{ $nomorRekom }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>:</td>
                <td>
                    <strong class="perihal-text">
                        Rekomendasi Pembuatan
                        <span>Paspor PMI{{ $destinasiTujuan !== '-' ? ' ' . $destinasiTujuan : '' }}</span>
                    </strong>
                </td>
            </tr>
        </table>

        <div class="tujuan">
            <strong>Kepada Yth.</strong><br>
            <strong>Kepala KANTOR IMIGRASI MATARAM<br>di<br>
                <span style="margin-left: 25px; text-decoration: underline">TEMPAT</span>
            </strong>
        </div>

        <div class="content">
            <p>
                Sesuai dengan permohonan
                <strong>{{ $perusahaanName ?? '-' }}</strong>
                perihal tersebut di atas, telah kami adakan verifikasi atas dokumen CPMI.
            </p>

            <p>
                Bersama ini kami memberikan rekomendasi untuk pembuatan paspor CPMI sebanyak
                {{ $totalCpmi }}
                @if ($totalCpmiSpelled)
                    ({{ $totalCpmiSpelled }})
                @endif
                orang sesuai lampiran dengan rincian:
            </p>

            <table>
                <tbody>
                    <tr>
                        <td>Laki-laki</td>
                        <td>:</td>
                        <td style="word-spacing: 4px;">{{ $jumlahLaki }}</td>
                    </tr>
                    <tr>
                        <td>Perempuan</td>
                        <td>:</td>
                        <td style="word-spacing: 4px;">{{ $jumlahPerempuan }} </td>
                    </tr>
                </tbody>
            </table>

            <p>
                Sebagai bahan pertimbangan, kami sertakan dokumen PMI yang diperlukan. Demikian disampaikan, atas
                perhatiannya dan kerja sama yang baik kami ucapkan terima kasih.
            </p>
        </div>

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
    </div>
</body>

</html>

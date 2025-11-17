<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Surat Rekomendasi Paspor PMI</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 25mm 25mm 20mm 25mm;
        }

        @font-face {
            font-family: 'ArialCustom';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('asset/fonts/arial.ttf') }}") format('truetype');
        }

        body {
            font-family: 'ArialCustom', sans-serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.35;
            margin: 0;
        }

        body * {
            font-family: 'ArialCustom', sans-serif;
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
        }

        .kop-logo img {
            height: 75px;
            width: auto;
        }

        .kop-text {
            text-align: center;
            line-height: 1.1;
        }

        .kop-title-1 {
            font-size: 20px;
            font-weight: 400;
            margin: 0;
            letter-spacing: -0.5px;
            font-family: Arial, sans-serif;
        }

        .kop-title-2 {
            font-size: 21px;
            font-weight: 700;
            margin: 2px 0 4px 0;
            letter-spacing: -0.5px;
            font-family: Arial, sans-serif;
        }

        .kop-address {
            font-size: 14px;
            margin: 0;
            margin-top: 4px;
            font-family: Arial, sans-serif;
        }

        .divider {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            margin: 10px 0 22px;
        }

        .divider {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            margin: 8px 0 24px;
        }

        .tujuan {
            padding-bottom: 1rem;
            font-weight: bold;
        }

        .meta {
            width: 100%;
            font-size: 12pt;
            line-height: 1.3;
            margin-bottom: 18px;
            padding-bottom: 2rem;
        }

        .meta td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .meta td:first-child {
            width: 100px;
        }

        .meta td:nth-child(2) {
            width: 15px;
            text-align: right;
            letter-spacing: 0;
        }

        .meta td:last-child {
            font-weight: normal;
        }

        .meta strong {
            text-transform: none;
            font-weight: bold;
        }

        .date {
            text-align: right;
            margin-bottom: 14px;
        }

        .content {
            text-align: left;
        }

        .content p {
            margin: 0 0 12px;
            text-indent: 1.25cm;
        }

        .content .no-indent {
            text-indent: 0;
        }

        .signature-block {
            width: 50%;
            margin-left: auto;
            margin-top: 70px;
            text-align: left;
            font-size: 12pt;
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

        .signature-block .nip {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="page">
        @php
            $perusahaanList = $rekomendasi->tenagaKerjas
                ->map(fn($tk) => optional($tk->perusahaan)->nama)
                ->filter()
                ->unique()
                ->values();

            $negaraList = $rekomendasi->tenagaKerjas
                ->map(fn($tk) => optional($tk->negara)->nama)
                ->filter()
                ->unique()
                ->values();

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
                <td style="width:130px;" class="kop-logo">
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
                    <strong>
                        Rekomendasi Pembuatan <br>
                        Paspor PMI{{ $destinasiTujuan !== '-' ? ' ' . $destinasiTujuan : '' }}
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

            <p class="no-indent">
                Laki-laki : {{ $jumlahLaki }} orang
            </p>
            <p class="no-indent">
                Perempuan : {{ $jumlahPerempuan }} orang
            </p>

            <p>
                Sebagai bahan pertimbangan, kami sertakan dokumen PMI yang diperlukan. Demikian disampaikan, atas
                perhatiannya dan kerja sama yang baik kami ucapkan terima kasih.
            </p>
        </div>

        <div class="signature-block">
            @if ($author)
                <p class="position">{{ strtoupper($author->jabatan) }}</p>
                <div class="space"></div>
                <p class="name"><u>{{ strtoupper($author->nama) }}</u></p>
                <p class="nip">NIP {{ $author->nip ?? '-' }}</p>
            @else
                <p class="position">A.N. KEPALA DISNAKERTRANS KAB. LOMBOK TENGAH</p>
                <p class="position">KABID PENEMPATAN DAN PERLUASAN KERJA</p>
                <div class="space"></div>
                <p class="name"><u>SUPIANDI, S.STP</u></p>
                <p class="nip">NIP 198201182002121001</p>
            @endif
        </div>
    </div>
</body>

</html>

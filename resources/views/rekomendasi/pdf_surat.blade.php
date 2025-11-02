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

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #000;
            line-height: 1.6;
        }

        .header {
            height: 120px;
            margin-bottom: 10px;
        }

        .tujuan {
            padding-bottom: 1rem;
        }

        .meta {
            width: 100%;
            font-size: 11pt;
            line-height: 1.4;
            margin-bottom: 10px;
            padding-bottom: 2rem;
        }

        .meta td {
            padding: 3px 5px;
            vertical-align: top;
        }

        .meta td:first-child {
            width: 90px;
        }

        .meta td:nth-child(2) {
            width: 15px;
            letter-spacing: 3px;
            text-align: right;
        }

        .meta td:last-child {
            font-weight: normal;
        }

        .meta strong {
            text-transform: uppercase;
        }

        .date {
            text-align: right;
            margin-bottom: 12px;
        }

        .content {
            text-align: justify;
        }

        .content p {
            margin: 0 0 10px;
        }

        .content .no-indent {
            text-indent: 0;
        }

        .signature-block {
            width: 90%;
            padding-left: 4cm;
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
        $perusahaanName = optional($rekom->perusahaan)->nama;
        $nomorRekom = $rekom->nomor ?? '-';
        $totalCpmi = $rekom->total ?? 0;
        $jumlahLaki = $rekom->jumlah_laki ?? 0;
        $jumlahPerempuan = $rekom->jumlah_perempuan ?? 0;
        $destinasiTujuan = $destinasi ?? null ?: '-';

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
        $jumlahLakiSpelled = $spellNumber($jumlahLaki);
        $jumlahPerempuanSpelled = $spellNumber($jumlahPerempuan);
    @endphp
    <div class="header"></div>
    <div class="date">
        Lombok Tengah, {{ $tanggal ?? '-' }}
    </div>

    <table class="meta">
        <tr>
            <td>Nomor</td>
            <td>:</td>
            <td style="word-spacing: 48px;">562/ LTSA/</td>
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
                    Rekomendasi Pembuatan <br> Paspor PMI{{ $destinasiTujuan !== '-' ? ' ' . $destinasiTujuan : '' }}
                </strong>
            </td>
        </tr>
    </table>

    <div class="tujuan">
        <strong>Kepada Yth.</strong><br>
        <strong>Kepala KANTOR IMIGRASI MATARAM<br>di<br><span
                style="margin-left: 25px; text-decoration: underline">TEMPAT</span></strong>
    </div>

    <div class="content">
        <p>
            Sesuai dengan permohonan
            <strong>{{ $perusahaanName ?? '-' }}</strong>
            perihal tersebut di atas, telah kami adakan verifikasi atas dokumen CPMI.
        </p>

        <p>
            Bersama ini kami memberikan rekomendasi untuk pembuatan paspor CPMI sebanyak
            {{ $totalCpmi }}@if ($totalCpmiSpelled)
                ({{ $totalCpmiSpelled }})
            @endif orang,
            sebagaimana daftar lampiran, terdiri dari CPMI :
        </p>

        <p class="no-indent">
            Laki-laki : {{ $jumlahLaki }}
        </p>
        <p class="no-indent">
            Perempuan : {{ $jumlahPerempuan }}
        </p>

        <p>
            Sebagai bahan pertimbangan, kami sertakan dokumen PMI yang diperlukan. Demikian disampaikan, atas
            perhatiannya dan kerja sama yang baik kami ucapkan terima kasih.
        </p>
    </div>

    <div class="signature-block">
        <p class="position">A.N. Kepala Disnakertrans Kab. Lombok Tengah</p>
        <p class="position">Kabid Penempatan dan Perluasan Kerja</p>
        <div class="space"></div>
        <p class="name"><u>SUPIANDI, S.STP</u></p>
        <p class="nip">NIP 198201182002121001</p>
    </div>
</body>

</html>

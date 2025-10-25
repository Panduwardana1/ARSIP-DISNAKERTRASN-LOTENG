<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Surat Rekomendasi {{ $rekom->nomor }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 25mm 25mm 20mm 25mm;
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

        .cover {
            text-align: center;
        }

        .brand h1 {
            font-size: 18pt;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .brand h2 {
            font-size: 14pt;
            margin-top: 4px;
            text-transform: uppercase;
        }

        .brand p {
            margin-top: 4px;
            font-size: 11pt;
        }

        .brand hr {
            border: 0;
            border-top: 3px double #000;
            margin: 12px 0 18px;
        }

        .letter-meta {
            margin: 0 auto 16px;
            width: 100%;
            border-collapse: collapse;
            font-size: 11pt;
        }

        .letter-meta td:first-child {
            width: 130px;
            font-weight: 600;
        }

        .letter-meta td:nth-child(2) {
            width: 12px;
        }

        .letter-meta td {
            padding: 3px 6px;
            vertical-align: top;
        }

        .letter-body {
            text-align: justify;
            margin-top: 18px;
        }

        .letter-body p {
            margin: 0 0 12px;
            text-indent: 24px;
        }

        .letter-body p.salutation,
        .letter-body p.closing {
            text-indent: 0;
        }

        .letter-date {
            text-align: right;
            margin-top: 12px;
            font-size: 11pt;
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
    </style>
</head>

<body>
    <div class="cover">
        <div class="brand">
            <h1>Pemerintah Kabupaten Kudus</h1>
            <h2>Dinas Tenaga Kerja, Perindustrian, Koperasi dan UKM</h2>
            <p>Jl. Mejobo No. 99 Kudus &middot; Telp (0291) 123456 &middot; email: disnaker@kuduskab.go.id</p>
            <hr>
        </div>

        <div class="letter-date">
            Kudus, {{ $tanggal }}
        </div>

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
    </div>
</body>

</html>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Surat Rekomendasi</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 18mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111;
        }

        .center {
            text-align: center;
        }

        .kop h2 {
            margin: 0;
            font-size: 16px;
            letter-spacing: .5px;
        }

        .kop h3 {
            margin: 2px 0 0;
            font-size: 14px;
        }

        .kop .alamat {
            font-size: 10px;
            margin-top: 4px;
        }

        .hr-1 {
            border: 0;
            border-top: 2px solid #000;
            margin: 8px 0 0;
        }

        .hr-2 {
            border: 0;
            border-top: 1px solid #000;
            margin: 2px 0 14px;
        }

        .kolom {
            width: 100%;
            margin-top: 10px;
        }

        .kolom td {
            vertical-align: top;
            padding: 2px 0;
        }

        .mt-24 {
            margin-top: 24px;
        }

        .mb-8 {
            margin-bottom: 8px;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }

        .ttd td {
            vertical-align: bottom;
        }

        .kanan {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .u {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <div class="kop center">
        <h2>PEMERINTAH KABUPATEN KUDUS</h2>
        <h3>DINAS TENAGA KERJA, PERINDUSTRIAN, KOPERASI DAN UKM</h3>
        <div class="alamat">Jl. Mejobo No. 99 Kudus • Telp (0291) 123456 • email: disnaker@kuduskab.go.id</div>
    </div>
    <hr class="hr-1">
    <hr class="hr-2">

    {{-- Tanggal & Kota --}}
    <div class="kanan mb-8">Kudus,
        {{ \Illuminate\Support\Carbon::parse($rekomendasi->tanggal)->translatedFormat('d F Y') }}</div>

    {{-- Nomor / Lampiran / Hal --}}
    <table class="kolom">
        <tr>
            <td width="80">Nomor</td>
            <td width="10">:</td>
            <td>{{ $rekomendasi->kode }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>-</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td class="bold">Rekomendasi Pengurusan Paspor</td>
        </tr>
    </table>

    <div class="mt-24">
        Kepada Yth.<br>
        Kepala Kantor Imigrasi _______________________<br>
        di tempat
    </div>

    <div class="mt-24" style="text-align:justify; line-height:1.5;">
        Dengan hormat,<br>
        Bersama ini kami mengajukan permohonan rekomendasi penerbitan paspor bagi calon pekerja migran Indonesia
        sebagaimana tercantum pada lampiran. Seluruh data telah kami verifikasi sesuai ketentuan dan dapat digunakan
        sebagai bahan pengurusan lebih lanjut.
    </div>

    <div class="mt-24" style="text-align:justify; line-height:1.5;">
        Demikian disampaikan, atas perhatian dan kerja samanya kami ucapkan terima kasih.
    </div>

    {{-- Tanda tangan --}}
    <table class="ttd">
        <tr>
            <td width="50%"></td>
            <td width="50%" class="kanan">
                Hormat kami,<br>
                <span class="bold">KEPALA DINAS</span><br><br><br><br>
                <span class="bold u">{{ strtoupper($rekomendasi->author->nama) }}</span><br>
                NIP: {{ $rekomendasi->author->nip ?: '________________' }}
            </td>
        </tr>
    </table>
</body>

</html>

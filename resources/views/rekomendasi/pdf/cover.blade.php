<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 2cm 2.2cm;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        @page landscapePage {
            size: A4 landscape;
            margin: 1.5cm 1.5cm;
        }

        body {
            font-size: 12px;
            color: #1f2937;
        }

        .kop {
            text-align: center;
            border-bottom: 2px solid #1f2937;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .kop h1 {
            font-size: 18px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .kop p {
            margin: 2px 0;
        }

        .content p {
            margin-bottom: 12px;
            line-height: 1.6;
        }

        .table-summary {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .table-summary td {
            padding: 6px 8px;
        }

        .signature {
            margin-top: 40px;
            width: 100%;
        }

        .signature td {
            padding: 6px 8px;
            vertical-align: top;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="cover">
        <div class="kop">
            <h1>PEMERINTAH KABUPATEN LOMBOK TENGAH</h1>
            <p>DINAS TENAGA KERJA DAN TRANSMIGRASI</p>
            <p>Jl. Soekarno Hatta No. 12 Praya, Lombok Tengah</p>
        </div>

        <div class="content">
            <p>Nomor: <strong>{{ $rekomendasi->kode }}</strong></p>
            <p>Lampiran: 1 (satu) berkas</p>
            <p>Perihal: <strong>Rekomendasi Penerbitan Paspor</strong></p>

            <p>Kepada Yth,<br>
                Kepala Kantor Imigrasi Kelas I TPI Mataram<br>
                di Tempat</p>

            <p>Dengan hormat,</p>

            <p>
                Berdasarkan hasil verifikasi kelengkapan dokumen Calon Pekerja Migran Indonesia (CPMI),
                bersama ini kami sampaikan daftar nama tenaga kerja yang direkomendasikan untuk memperoleh
                layanan penerbitan paspor. Tenaga kerja tersebut telah memenuhi persyaratan administratif
                sesuai ketentuan yang berlaku.
            </p>

            <table class="table-summary">
                <tr>
                    <td style="width: 200px;">Kode Rekomendasi</td>
                    <td>: {{ $rekomendasi->kode }}</td>
                </tr>
                <tr>
                    <td>Tanggal Rekomendasi</td>
                    <td>: {{ $rekomendasi->tanggal?->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td>Total Tenaga Kerja</td>
                    <td>: {{ $rekomendasi->total }} orang</td>
                </tr>
                <tr>
                    <td>Verifikator</td>
                    <td>: {{ $rekomendasi->userVerifikasi->name ?? '-' }}</td>
                </tr>
            </table>

            <p>Demikian rekomendasi ini kami sampaikan. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        </div>

        <table class="signature">
            <tr>
                <td></td>
                <td style="text-align: left;">
                    Lombok Tengah, {{ now()->translatedFormat('d F Y') }}<br>
                    Kepala Dinas Tenaga Kerja dan Transmigrasi<br><br><br><br>
                    <strong>{{ $rekomendasi->author->nama }}</strong><br>
                    NIP. {{ $rekomendasi->author->nip }}
                </td>
            </tr>
        </table>
    </div>

    <div class="page-break">
        @include('rekomendasi.pdf.data', ['rekomendasi' => $rekomendasi, 'tenagaKerjas' => $tenagaKerjas])
    </div>
</body>

</html>

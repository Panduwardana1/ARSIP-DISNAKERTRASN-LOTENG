<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Lampiran Rekomendasi</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 12mm 14mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111;
        }

        .center {
            text-align: center;
        }

        .mb-8 {
            margin-bottom: 8px;
        }

        .mb-12 {
            margin-bottom: 12px;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 6px;
            vertical-align: top;
        }

        thead {
            background: #f3f3f3;
        }

        /* header tabel tetap muncul di setiap halaman */
        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-row-group;
        }

        tr {
            page-break-inside: avoid;
        }

        .no-border td {
            border: none;
            padding: 2px 6px;
        }

        .lables {
            font-size: 3rem;
        }
    </style>
</head>

<body>

    <h3 class="center mb-8">REKOMENDASI PASPOR</h3>
    <div class="center mb-12">Nomor: {{ $rekomendasi->kode }}</div>

    {{-- Ringkasan --}}
    <table class="no-border mb-12">
        <tr>
            <td width="30%">Tanggal Rekomendasi</td>
            <td width="2%">:</td>
            <td>{{ $stats['tanggal'] }}</td>
        </tr>
        <tr>
            <td>Total Peserta</td>
            <td>:</td>
            <td>{{ $stats['total'] }}</td>
        </tr>
        <tr>
            <td>Jumlah Laki-laki</td>
            <td>:</td>
            <td>{{ $stats['laki'] }}</td>
        </tr>
        <tr>
            <td>Jumlah Perempuan</td>
            <td>:</td>
            <td>{{ $stats['perempuan'] }}</td>
        </tr>
    </table>
    <strong class="labels">DISNAKERTRANS KAB. LOMBOK TENGAH</strong>
    <table>
        <thead>
            <tr>
                <th style="width:30px;">NO</th>
                <th style="width:220px;">Nama & ID PMI</th>
                <th style="width:70px;">Tempat <br> Tgl. Lahir</th>
                <th style="width:6px;">L/P</th>
                <th style="width:140px;">Alamat PMI</th>
                <th style="width:140px;">Agency</th>
                <th style="width:110px;">Jenis Pekerjaan</th>
                <th style="width:110px;">Pendidikan</th>
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
                    $jenisPekerjaan = optional($tk->perusahaan)->nama ?? '-';
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
                        <div>
                            {{ $tempatLahir }}<br>
                            {{ $tanggalLahir }}
                        </div>
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

</body>

</html>

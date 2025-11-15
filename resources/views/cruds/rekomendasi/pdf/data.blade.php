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

    {{-- Tabel detail --}}
    <table>
        <thead>
            <tr>
                <th style="width:30px;">NO</th>
                <th style="width:220px;">IDENTITAS</th>
                <th style="width:70px;">GENDER</th>
                <th style="width:85px;">PENDIDIKAN</th>
                <th style="width:140px;">PERUSAHAAN</th>
                <th style="width:140px;">AGENSI</th>
                <th style="width:110px;">DESTINASI</th>
                <th style="width:110px;">LOWONGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekomendasi->tenagaKerjas as $i => $tk)
                @php
                    $gender = $tk->gender ?? '-';
                    $pend = $tk->pendidikan->nama ?? '-';
                    $per = optional($tk->perusahaan)->nama ?? '-';
                    $agen = optional($tk->agensi ?? null)->nama ?? '-';
                    $dest = optional($tk->negara ?? ($tk->destinasi ?? null))->nama ?? '-';
                    $low = optional($tk->lowongan ?? null)->nama ?? '-';
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="bold">{{ $tk->nama }}</div>
                        NIK: {{ $tk->nik }}<br>
                        @if (!empty($tk->alamat))
                            {{ $tk->alamat }}
                        @endif
                    </td>
                    <td>{{ $gender }}</td>
                    <td>{{ $pend }}</td>
                    <td>{{ $per }}</td>
                    <td>{{ $agen }}</td>
                    <td>{{ $dest }}</td>
                    <td>{{ $low }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>

<style>
    .landscape-page {
        page: landscapePage;
    }

    .table-data {
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
        font-size: 10px;
    }

    .table-data th {
        background-color: #f3f4f6;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 8px 6px;
        border: 1px solid #d1d5db;
    }

    .table-data td {
        border: 1px solid #e5e7eb;
        padding: 6px 5px;
    }
</style>

<div class="landscape-page">
    <h2 style="text-align: center; font-size: 14px; text-transform: uppercase; margin-bottom: 8px;">
        Daftar Tenaga Kerja Rekomendasi Paspor
    </h2>
    <p style="text-align: center; margin-bottom: 10px;">
        Kode: <strong>{{ $rekomendasi->kode }}</strong> &mdash;
        Tanggal: {{ $rekomendasi->tanggal?->translatedFormat('d F Y') }}
    </p>

    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama</th>
                <th style="width: 110px;">NIK</th>
                <th style="width: 120px;">Tempat / Tgl Lahir</th>
                <th style="width: 120px;">Perusahaan</th>
                <th style="width: 120px;">Destinasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tenagaKerjas as $index => $tenagaKerja)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $tenagaKerja->nama }}</td>
                    <td>{{ $tenagaKerja->nik }}</td>
                    <td>
                        {{ $tenagaKerja->tempat_lahir ?? '-' }},
                        {{ optional($tenagaKerja->tanggal_lahir)->translatedFormat('d F Y') ?? '-' }}
                    </td>
                    <td>{{ $tenagaKerja->perusahaan->nama ?? '-' }}</td>
                    <td>{{ $tenagaKerja->negara->nama ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

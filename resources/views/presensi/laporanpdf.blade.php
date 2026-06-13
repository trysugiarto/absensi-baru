<!DOCTYPE html>
<html>
<head>
    <title>Laporan E-Absensi</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            position: relative;
        }

        .watermark {
            position: fixed;
            top: 120px;
            left: 70px;
            width: 100%;
            z-index: -1;
            font-size: 100px;
            font-weight: bold;
            color: rgba(255, 0, 0, 0.15);
            line-height: 150px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 25px;
        }

        .info {
            margin-bottom: 15px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background: #eee;
            padding: 6px;
            text-align: center;
            font-weight: bold;
        }

        td {
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }

        .foto {
            width: 45px;
            height: 35px;
            object-fit: cover;
        }

        .merah {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="watermark">
        E-Absensi<br>
        E-Absensi<br>
        E-Absensi
    </div>

    <h2>Laporan E-Absensi Karyawan</h2>

    <div class="info">
        <table style="width:300px; border:none;">
            <tr>
                <td style="border:none; text-align:left;">Nama</td>
                <td style="border:none;">:</td>
                <td style="border:none; text-align:left;">
                    <b>{{ $karyawan->nama_lengkap ?? '-' }}</b>
                </td>
            </tr>
            <tr>
                <td style="border:none; text-align:left;">Jabatan</td>
                <td style="border:none;">:</td>
                <td style="border:none; text-align:left;">
                    {{ $karyawan->jabatan ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="border:none; text-align:left;">NIK</td>
                <td style="border:none;">:</td>
                <td style="border:none; text-align:left;">
                    {{ $karyawan->nik ?? '-' }}
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Hari / Tanggal</th>
                <th>Jam Masuk</th>
                <th>Lokasi Masuk</th>
                <th>Foto Masuk</th>
                <th>Ket. Masuk</th>
                <th>Jam Pulang</th>
                <th>Lokasi Pulang</th>
                <th>Foto Pulang</th>
                <th>Ket. Pulang</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($historibulanini as $d)
                <tr>
                    <td>
                        {{ \Carbon\Carbon::parse($d->tgl_presensi)->translatedFormat('l, Y-m-d') }}
                    </td>

                    <td>{{ $d->jam_in ?? '-' }}</td>

                    <td>{{ $d->lokasi_in ?? '-' }}</td>

                    <td>
                        @if (!empty($d->foto_in))
                            <img class="foto"
                                 src="{{ public_path('storage/uploads/absensi/'.$d->foto_in) }}">
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ $d->keterangan_in ?? '-' }}</td>

                    <td>{{ $d->jam_out ?? '-' }}</td>

                    <td>{{ $d->lokasi_out ?? '-' }}</td>

                    <td>
                        @if (!empty($d->foto_out))
                            <img class="foto"
                                 src="{{ public_path('storage/uploads/absensi/'.$d->foto_out) }}">
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        @if (empty($d->jam_out))
                            <span class="merah">Tidak Absen</span>
                        @else
                            {{ $d->keterangan_out ?? '-' }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
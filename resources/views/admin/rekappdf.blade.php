<!DOCTYPE html>
<html>
<head>
    <title>Rekap Absensi</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:#0d6efd;
            color:white;
            padding:8px;
            border:1px solid #000;
        }

        table td{
            padding:7px;
            border:1px solid #000;
        }

        .text-center{
            text-align:center;
        }

        .terlambat{
            color:red;
            font-weight:bold;
        }

        .tepat{
            color:green;
            font-weight:bold;
        }

    </style>

</head>
<body>

    <h2>
        Rekap Absensi Bulan {{ $bulan }}
        Tahun {{ $tahun }}
    </h2>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Keterangan</th>
            </tr>

        </thead>

        <tbody>

            @foreach($rekap as $d)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $d->nama_lengkap }}
                </td>

                <td>
                    {{ $d->jabatan }}
                </td>

                <td>
                    {{ $d->tgl_presensi }}
                </td>

                <td>
                    {{ $d->jam_in }}
                </td>

                <td>
                    {{ $d->jam_out }}
                </td>

                <td>

                    @if($d->keterangan_in == 'Terlambat')

                        <span class="terlambat">
                            Terlambat
                        </span>

                    @else

                        <span class="tepat">
                            Tepat Waktu
                        </span>

                    @endif

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>
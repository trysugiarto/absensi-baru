@extends('layouts.absensi')

@section('header')
<div class="appHeader bg-primary text-light">

    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>

    <div class="pageTitle">
        Laporan
    </div>

    <div class="right"></div>

</div>
@endsection

@section('content')

<style>

    .history-scroll{
        height:500px;
        overflow-y:auto;
        overflow-x:hidden;
        margin-top:15px;
        padding-bottom:10px;
    }

    .history-scroll table{
        margin-bottom:0;
    }

    .history-scroll thead th{
        position:sticky;
        top:0;
        background:#fff;
        z-index:10;
    }

</style>

<div class="section mt-2">

    <div class="card">

        <div class="card-body">

            <h3 class="mb-3">
                Laporan Absensi
            </h3>

            <!-- FORM FILTER -->

            <form method="GET"
                  action="{{ url('/laporan') }}"
                  id="formLaporan">

                <div class="row">

                    <!-- BULAN -->

                    <div class="col-6">

                        <select name="bulan"
                                class="form-control"
                                onchange="document.getElementById('formLaporan').submit()">

                            <option value="">
                                Bulan
                            </option>

                            @for ($i = 1; $i <= 12; $i++)

                                <option value="{{ sprintf('%02d', $i) }}"
                                    {{ request('bulan', date('m')) == sprintf('%02d', $i) ? 'selected' : '' }}>

                                    {{ date('F', mktime(0,0,0,$i,1)) }}

                                </option>

                            @endfor

                        </select>

                    </div>

                    <!-- TAHUN -->

                    <div class="col-6">

                        <select name="tahun"
                                class="form-control"
                                onchange="document.getElementById('formLaporan').submit()">

                            <option value="">
                                Tahun
                            </option>

                            @for ($y = 2026; $y <= 2031; $y++)

                                <option value="{{ $y }}"
                                    {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>

                                    {{ $y }}

                                </option>

                            @endfor

                        </select>

                    </div>

                </div>

            </form>

            <!-- BUTTON EXPORT PDF -->

            <a href="javascript:void(0)"
               onclick="cekExportPDF('{{ url('/laporan/exportpdf?bulan='.request('bulan', date('m')).'&tahun='.request('tahun', date('Y'))) }}')"
               class="btn btn-danger btn-block mb-2 mt-2">

                <ion-icon name="download-outline"></ion-icon>

                Export PDF

            </a>

            <!-- TABLE -->

            <div class="history-scroll">

                <table class="table table-bordered text-center">

                    <thead>

                        <tr>

                            <th>Tanggal</th>
                            <th>Masuk</th>
                            <th>Pulang</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($historibulanini as $d)

                            <tr>

                                <td>
                                    {{ date('d-m-Y', strtotime($d->tgl_presensi)) }}
                                </td>

                                <td>
                                    {{ $d->jam_in ?? '-' }}
                                </td>

                                <td>
                                    {{ $d->jam_out ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="3">
                                    Data tidak ditemukan
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection


@push('myscript')

<script>

function cekExportPDF(url){

    let hariIni = new Date().getDate();

    if(hariIni >= 1 && hariIni <= 7){

        Swal.fire({

            icon:'success',

            title:'Berhasil!',

            text:'Segera Berikan Ke Pengawas',

            confirmButtonText:'OK'

        }).then(() => {

            window.location.href = url;

        });

    }else{

        Swal.fire({

            icon:'error',

            title:'Error!',

            text:'Laporan Di Tutup',

            confirmButtonText:'OK'

        });

    }

}

</script>

@endpush
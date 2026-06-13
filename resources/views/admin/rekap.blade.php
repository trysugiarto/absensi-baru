@extends('layouts.absensi')

@section('header')
<div class="appHeader bg-primary text-light">

    <div class="left">
        <a href="{{ url('/admin/dashboard') }}"
           class="headerButton">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>

    <div class="pageTitle">
        Rekap Absensi
    </div>

    <div class="right"></div>

</div>
@endsection

@section('content')

<div class="section"
     style="margin-top:70px; margin-bottom:90px;">

    <div class="card">
        <div class="card-body">

            <form method="GET"
                  action="{{ url('/admin/rekap') }}">

                <div class="row">

                    <div class="col-6">

                        <div class="form-group">

                            <label>Bulan</label>

                            <select name="bulan"
                                    class="form-control">

                                @for($i = 1; $i <= 12; $i++)

                                <option value="{{ $i }}"
                                    {{ $bulan == $i ? 'selected' : '' }}>

                                    {{ $i }}

                                </option>

                                @endfor

                            </select>

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="form-group">

                            <label>Tahun</label>

                            <select name="tahun"
                                    class="form-control">

                                @for($i = 2025; $i <= 2035; $i++)

                                <option value="{{ $i }}"
                                    {{ $tahun == $i ? 'selected' : '' }}>

                                    {{ $i }}

                                </option>

                                @endfor

                            </select>

                        </div>

                    </div>

                </div>

                <button type="submit"
        class="btn btn-primary btn-block mb-3">

    Tampilkan Rekap

</button>

<a href="{{ url('/admin/rekap/exportpdf?bulan='.$bulan.'&tahun='.$tahun) }}"
   class="btn btn-danger btn-block mb-3">

    Export PDF

</a>

               
            </form>

            @foreach($rekap as $d)

            <div class="card mb-2 shadow-sm">
                <div class="card-body">

                    <h4>
                        {{ $d->nama_lengkap }}
                    </h4>

                    <p class="mb-1">
                        <b>Tanggal :</b>
                        {{ $d->tgl_presensi }}
                    </p>

                    <p class="mb-1">
                        <b>Jabatan :</b>
                        {{ $d->jabatan }}
                    </p>

                    <p class="mb-1">
                        <b>Jam Masuk :</b>
                        {{ $d->jam_in }}
                    </p>

                    <p class="mb-1">
                        <b>Jam Pulang :</b>
                        {{ $d->jam_out }}
                    </p>

                    <p class="mb-0">
                        <b>Keterangan :</b>

                        @if($d->keterangan_in == 'Terlambat')

                            <span class="badge badge-danger">
                                Terlambat
                            </span>

                        @else

                            <span class="badge badge-success">
                                Tepat Waktu
                            </span>

                        @endif

                    </p>

                </div>
            </div>

            @endforeach

        </div>
    </div>

</div>

@endsection
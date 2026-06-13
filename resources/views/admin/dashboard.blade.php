@extends('layouts.absensi')

@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left"></div>
    <div class="pageTitle">Dashboard Admin</div>
    <div class="right"></div>
</div>
@endsection

@section('content')

<div class="section mt-2" style="margin-top:70px !important;">

    <div class="row">

        <div class="col-6 mb-2">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $jumlahkaryawan }}</h2>
                    <span>Total Karyawan</span>
                </div>
            </div>
        </div>

        <div class="col-6 mb-2">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $hadirhariini }}</h2>
                    <span>Hadir Hari Ini</span>
                </div>
            </div>
        </div>

        <div class="col-6 mb-2">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $terlambat }}</h2>
                    <span>Terlambat</span>
                </div>
            </div>
        </div>

        <div class="col-6 mb-2">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h2 class="text-white">{{ $belumabsen }}</h2>
                    <span>Belum Absen</span>
                </div>
            </div>
        </div>

    </div>

    <div class="card mt-2">
        <div class="card-body">

            <a href="{{ url('/admin/rekap') }}"
               class="btn btn-primary btn-block mb-2">
                Rekap Semua Absensi
            </a>

            <a href="{{ url('/admin/karyawan') }}"
               class="btn btn-success btn-block mb-2">
                Data Karyawan
            </a>

            <a href="{{ url('/admin/rekap/exportpdf?bulan='.date('m').'&tahun='.date('Y')) }}"
   class="btn btn-danger btn-block mb-2">
    Export PDF
</a>

            <a href="{{ url('/dashboard') }}"
               class="btn btn-warning btn-block mb-2">
                Dashboard Karyawan
            </a>

            <a href="{{ url('/logout') }}"
               class="btn btn-secondary btn-block">
                Logout
            </a>

        </div>
    </div>

</div>

@endsection
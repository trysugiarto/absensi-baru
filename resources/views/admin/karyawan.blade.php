@extends('layouts.absensi')

@section('header')
<div class="appHeader bg-primary text-light">

    <div class="left">
        <a href="{{ url('/admin/dashboard') }}" class="headerButton">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>

    <div class="pageTitle">
        Data Karyawan
    </div>

    <div class="right"></div>

</div>
@endsection

@section('content')

<div class="section" style="margin-top:70px; margin-bottom:90px;">

    <div class="card">
        <div class="card-body">

            <a href="{{ url('/admin/karyawan/tambah') }}"
               class="btn btn-primary btn-block mb-3">
                <ion-icon name="person-add-outline"></ion-icon>
                Tambah Karyawan
            </a>

            <form method="GET"
                  action="{{ url('/admin/karyawan') }}">

                <div class="input-group mb-3">

                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari Nama / NIK"
                           value="{{ request('search') }}">

                    <div class="input-group-append">
                        <button class="btn btn-primary">
                            Cari
                        </button>
                    </div>

                </div>

            </form>

            @foreach($karyawan as $d)

            <div class="card mb-2 shadow-sm">
                <div class="card-body">

                    <h4>
                        {{ $d->nama_lengkap }}
                    </h4>

                    <p class="mb-1">
                        <b>NIK :</b> {{ $d->nik }}
                    </p>

                    <p class="mb-1">
                        <b>Jabatan :</b> {{ $d->jabatan }}
                    </p>

                    <p class="mb-2">
                        <b>Role :</b>

                        @if($d->role == 'admin')
                            <span class="badge badge-primary">
                                Admin
                            </span>
                        @else
                            <span class="badge badge-success">
                                Karyawan
                            </span>
                        @endif
                    </p>

                    <div class="d-flex">

                        <a href="{{ url('/admin/karyawan/edit/'.$d->nik) }}"
                           class="btn btn-warning btn-sm mr-1">
                            Edit
                        </a>

                        <a href="{{ url('/admin/karyawan/delete/'.$d->nik) }}"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus data?')">
                            Hapus
                        </a>

                    </div>

                </div>
            </div>

            @endforeach

        </div>
    </div>

</div>

@endsection
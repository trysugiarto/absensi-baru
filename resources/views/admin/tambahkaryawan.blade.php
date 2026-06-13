@extends('layouts.absensi')

@section('header')
<div class="appHeader bg-primary text-light">

    <div class="left">
        <a href="{{ url('/admin/karyawan') }}" class="headerButton">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>

    <div class="pageTitle">
        Edit Karyawan
    </div>

    <div class="right"></div>

</div>
@endsection

@section('content')

<div class="section" style="margin-top:70px;">

    <div class="card">
        <div class="card-body">

            <form action="{{ url('/admin/karyawan/update/'.$karyawan->nik) }}"
                  method="POST">

                @csrf

                <div class="form-group">

                    <label>NIK</label>

                    <input type="text"
                           value="{{ $karyawan->nik }}"
                           class="form-control"
                           readonly>

                </div>

                <div class="form-group">

                    <label>Nama Lengkap</label>

                    <input type="text"
                           name="nama_lengkap"
                           value="{{ $karyawan->nama_lengkap }}"
                           class="form-control"
                           required>

                </div>

                <div class="form-group">

                    <label>Jabatan</label>

                    <input type="text"
                           name="jabatan"
                           value="{{ $karyawan->jabatan }}"
                           class="form-control"
                           required>

                </div>

                <div class="form-group">

                    <label>No HP</label>

                    <input type="text"
                           name="no_hp"
                           value="{{ $karyawan->no_hp }}"
                           class="form-control"
                           required>

                </div>

                <div class="form-group">

                    <label>Role</label>

                    <select name="role"
                            class="form-control">

                        <option value="karyawan"
                            {{ $karyawan->role == 'karyawan' ? 'selected' : '' }}>
                            Karyawan
                        </option>

                        <option value="admin"
                            {{ $karyawan->role == 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Password Baru</label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Kosongkan jika tidak diganti">

                </div>

                <button type="submit"
                        class="btn btn-primary btn-block">

                    Update

                </button>

            </form>

        </div>
    </div>

</div>

@endsection
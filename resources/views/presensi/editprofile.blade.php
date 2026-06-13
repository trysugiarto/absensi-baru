@extends('layouts.absensi')

@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>

    <div class="pageTitle">Edit Profile</div>

    <div class="right"></div>
</div>
@endsection

@section('content')

<div class="row" style="margin-top:4rem">
    <div class="col">

        @php
            $messagesuccess = Session::get('success');
            $messageerror = Session::get('error');
        @endphp

        @if($messagesuccess)
            <div class="alert alert-success">
                {{ $messagesuccess }}
            </div>
        @endif

        @if($messageerror)
            <div class="alert alert-danger">
                {{ $messageerror }}
            </div>
        @endif

        <form action="/editprofile"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <!-- Nama -->
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="text"
                           class="form-control"
                           value="{{ $karyawan->nama_lengkap }}"
                           name="nama_lengkap"
                           placeholder="Nama Lengkap"
                           autocomplete="off">
                </div>
            </div>

            <!-- No HP -->
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="text"
                           class="form-control"
                           value="{{ $karyawan->no_hp }}"
                           name="no_hp"
                           placeholder="No. HP"
                           autocomplete="off">
                </div>
            </div>

            <!-- Password -->
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="password"
                           class="form-control"
                           name="password"
                           placeholder="Password"
                           autocomplete="off">
                </div>
            </div>

            <!-- Upload Foto -->
            <div class="custom-file-upload" id="fileUpload1">
                <input type="file"
                       name="foto"
                       id="fileuploadInput"
                       accept=".png, .jpg, .jpeg">

                <label for="fileuploadInput">
                    <span>
                        <strong>
                            <ion-icon name="cloud-upload-outline"></ion-icon>
                            <i>Tap to Upload</i>
                        </strong>
                    </span>
                </label>
            </div>

            <!-- Tombol Update -->
            <div class="form-group boxed">
    <div class="input-wrapper">
        <button type="submit" class="btn btn-primary btn-block">
            <ion-icon name="refresh-outline"></ion-icon>
            Update
        </button>
    </div>
</div>

<div class="form-group boxed">
    <div class="input-wrapper">

        <a href="{{ url('/logout') }}"
           class="btn btn-danger btn-block mt-2"
           style="height:45px; display:flex; align-items:center; justify-content:center; gap:8px;"
           onclick="return confirm('Yakin ingin logout?')">

            <ion-icon name="log-out-outline"></ion-icon>
            Logout

        </a>

    </div>
</div>

</form>

@endsection
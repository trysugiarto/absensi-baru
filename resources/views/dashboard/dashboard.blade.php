@extends('layouts.absensi')
@section('content')

<style>

#appCapsule{
    padding-top:5px !important;
    margin-top:0 !important;
}

#user-section{
    background:linear-gradient(
        135deg,
        #2563eb,
        #1d4ed8,
        #1e40af
    );
    margin-top:-10px;
    padding-top:29px !important;
    padding-bottom:28px !important;
    border-bottom-left-radius:10px;
    border-bottom-right-radius:10px;
    box-shadow:0 4px 12px rgba(0,0,0,0.18);
}

#user-detail{
    display:flex;
    align-items:center;
}

#menu-section{
    margin-top:-135px;
    position:relative;
    z-index:10;
}

#presence-section{
    margin-top:85px;
}

.nav-tabs .nav-item{
    width:auto !important;
}

.nav-tabs .nav-link{
    background:#0d47a1 !important;
    color:white !important;
    font-weight:bold;
    padding:6px 14px;
    border-radius:10px;
    font-size:13px;
    display:inline-block;
    min-width:auto;
}

.nav-tabs .nav-link.active{
    background:#1565c0 !important;
    color:white !important;
}

/* SCROLL HISTORY */
.tab-content{
    scroll-behavior:smooth;
}

.tab-content::-webkit-scrollbar{
    width:6px;
}

.tab-content::-webkit-scrollbar-track{
    background:#e5e7eb;
    border-radius:10px;
}

.tab-content::-webkit-scrollbar-thumb{
    background:#2563eb;
    border-radius:10px;
}

.tab-content::-webkit-scrollbar-thumb:hover{
    background:#1d4ed8;
}

</style>

<div class="section" id="user-section">
    <div id="user-detail">

        <div class="avatar" style="margin-left:8px;">
            @if(!empty(Auth::guard('karyawan')->user()->foto))
                @php
                    $path = Storage::url(
                        'uploads/karyawan/' .
                        Auth::guard('karyawan')->user()->foto
                    );
                @endphp

                <img src="{{ url($path) }}"
                     alt="avatar"
                     style="
                        width:90px;
                        height:90px;
                        border-radius:40%;
                        object-fit:cover;
                        border:3px solid #fff;
                     ">
            @else
                <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}"
                     alt="avatar"
                     style="
                        width:90px;
                        height:90px;
                        border-radius:40%;
                        object-fit:cover;
                        border:3px solid #fff;
                     ">
            @endif
        </div>

        <div id="user-info" style="margin-left:5px;">
            <h2 id="user-name"
                style="
                    font-size:25px;
                    color:white;
                    margin:0;
                ">
                {{ Auth::guard('karyawan')->user()->nama_lengkap }}
            </h2>

            <span id="user-role"
                  style="
                    color:white;
                    margin-top:4px;
                    font-size:18px;
                    font-weight:500;
                    line-height:1.2;
                    opacity:0.95;
                  ">
                {{ Auth::guard('karyawan')->user()->jabatan }}
            </span>
        </div>

    </div>
</div>

<div class="section" id="menu-section">
    <div class="card">
        <div class="card-body text-center"
             style="
                height:200px;
                padding-top:6px;
                padding-bottom:2px;
                justify-content:center;
                align-items:center;
                overflow:visible;
             ">

            <div style="width:360px;">
                <div id="tanggal"
                     style="
                        font-size:14px;
                        margin-bottom:1px;
                     ">
                </div>

                <div id="jam"
                     style="
                        font-size:90px;
                        font-weight:bold;
                        line-height:1;
                        color:#16a34a;
                     ">
                </div>

                <div style="
                    margin-top:2px;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    gap:6px;
                    color:#0d47a1;
                    font-weight:bold;
                ">

                    <div style="
                        width:22px;
                        height:22px;
                        border-radius:7px;
                        background:#0d47a1;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                    ">
                        <ion-icon
                            name="time-outline"
                            style="
                                color:white;
                                font-size:14px;
                            ">
                        </ion-icon>
                    </div>

                    <span>Jadwal E-Absensi</span>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="section" id="presence-section">

    <div class="todaypresence">
        <div class="row">

            <!-- MASUK -->
            <div class="col-6">
                <div class="card gradasigreen">
                    <div class="card-body">
                        <div class="presencecontent">

                            <div class="iconpresence">
                                @if ($presensihariini != null && $presensihariini->foto_in != null)
                                    <img src="{{ asset('storage/uploads/absensi/' . $presensihariini->foto_in) }}"
                                         alt="Foto Masuk"
                                         style="
                                            width:40px;
                                            height:40px;
                                            object-fit:cover;
                                            border-radius:10px;
                                         ">
                                @else
                                    <ion-icon name="camera"></ion-icon>
                                @endif
                            </div>

                            <div class="presencedetail">
                                <h4 class="presencetitle">
                                    Masuk
                                </h4>

                                <span>
                                    {{ $presensihariini != null && $presensihariini->jam_in != null ? $presensihariini->jam_in : 'Belum Absen' }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- PULANG -->
            <div class="col-6">
                <div class="card gradasired">
                    <div class="card-body">
                        <div class="presencecontent">

                            <div class="iconpresence">
                                @if ($presensihariini != null && $presensihariini->foto_out != null)
                                    <img src="{{ asset('storage/uploads/absensi/' . $presensihariini->foto_out) }}"
                                         alt="Foto Pulang"
                                         style="
                                            width:40px;
                                            height:40px;
                                            object-fit:cover;
                                            border-radius:10px;
                                         ">
                                @else
                                    <ion-icon name="camera"></ion-icon>
                                @endif
                            </div>

                            <div class="presencedetail">
                                <h4 class="presencetitle">
                                    Pulang
                                </h4>

                                <span>
                                    {{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : '--:--' }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- HISTORY -->
    <div class="presencetab mt-2">

        <div class="tab-pane fade show active"
             id="pilled"
             role="tabpanel">

            <ul class="nav nav-tabs style1"
                role="tablist">

                <li class="nav-item">
                    <a class="nav-link active"
                       data-toggle="tab"
                       href="#home"
                       role="tab">
                        History E-Absensi
                    </a>
                </li>

            </ul>
        </div>

        <!-- AREA SCROLL HISTORY -->
        <div class="tab-content mt-1"
             style="
                margin-bottom:100px;
                max-height:340px;
                overflow-y:auto;
                overflow-x:hidden;
                border:1px solid #d1d5db;
                border-radius:10px;
                background:white;
             ">

            <div class="tab-pane fade show active"
                 id="home"
                 role="tabpanel">

                <ul class="listview image-listview">

                    @foreach ($historibulanini as $d)

                    <li style="margin-bottom:2px;">
                        <div class="item"
                             style="
                                padding-top:5px;
                                padding-bottom:5px;
                             ">

                            <div class="icon-box bg-primary">
                                <ion-icon name="finger-print-outline"></ion-icon>
                            </div>

                            <div class="in">

                                <!-- TANGGAL -->
                                <div>
                                    {{ date("d-m-Y", strtotime($d->tgl_presensi)) }}
                                </div>

                                <!-- JAM MASUK -->
                                <span class="badge badge-success">
                                    {{ $d->jam_in }}
                                </span>

                               <!-- KETERANGAN MASUK -->
@if($d->keterangan_in == 'Terlambat')

    <span class="badge badge-warning"
          style="
            background:#f59e0b;
            color:white;
            font-size:10px;
            padding:3px 6px;
          ">
        Terlambat
    </span>

@elseif($d->keterangan_in == 'Tepat Waktu')

    <span class="badge badge-success"
          style="
            font-size:10px;
            padding:3px 6px;
          ">
        Tepat Waktu
    </span>

@endif


<!-- JAM / STATUS PULANG -->
@if(empty($d->jam_out))

    @if(date('H:i') < '17:30')

        <span class="badge badge-danger"
              style="
                background:#f59e0b;
                color:white;
                font-size:10px;
                padding:3px 6px;
              ">
            Belum Absen
        </span>

    @else

        <span class="badge badge-danger"
              style="
                font-size:10px;
                padding:3px 6px;
              ">
            Tidak Absen
        </span>

    @endif

@else

    <span class="badge badge-danger"
          style="
            font-size:10px;
            padding:3px 6px;
          ">
        {{ $d->jam_out }}
    </span>

@endif


<!-- KETERANGAN PULANG -->
@if(!empty($d->keterangan_out))

    <span class="badge badge-primary"
          style="
            font-size:10px;
            padding:3px 6px;
          ">
        {{ $d->keterangan_out }}
    </span>

@endif

                            </div>

                        </div>
                    </li>

                    @endforeach

                </ul>

            </div>
        </div>

    </div>

</div>

<script>

function updateJam() {

    const now = new Date();

    const hari = [
        "Minggu","Senin","Selasa",
        "Rabu","Kamis","Jumat","Sabtu"
    ];

    const bulan = [
        "Januari","Februari","Maret","April",
        "Mei","Juni","Juli","Agustus",
        "September","Oktober","November","Desember"
    ];

    let tanggal =
        hari[now.getDay()] + ", " +
        now.getDate() + " " +
        bulan[now.getMonth()] + " " +
        now.getFullYear();

    let jam =
        String(now.getHours()).padStart(2,'0') + ":" +
        String(now.getMinutes()).padStart(2,'0');

    document.getElementById("tanggal").innerHTML = tanggal;
    document.getElementById("jam").innerHTML = jam;
}

setInterval(updateJam, 1000);

updateJam();

</script>

@endsection
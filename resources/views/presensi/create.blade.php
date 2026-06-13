@extends('layouts.absensi')

@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>

    <div class="pageTitle">E-Absensi</div>
    <div class="right"></div>
</div>

<style>
    .webcam-capture,
    .webcam-capture video {
        display: inline-block;
        width: 100% !important;
        height: auto !important;
        border-radius: 15px;
    }

    #map {
        height: 280px;
        border-radius: 15px;
    }
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

@section('content')
<div class="row" style="margin-top:70px">
    <div class="col">
        <input type="hidden" id="lokasi">
        <div class="webcam-capture"></div>
    </div>
</div>

<div class="row mt-2">
    <div class="col">
        @if ($cek > 0)
            <button id="takeabsen" class="btn btn-danger btn-block">
                <ion-icon name="camera-outline"></ion-icon>
                Absen Pulang
            </button>
        @else
            <button id="takeabsen" class="btn btn-primary btn-block">
                <ion-icon name="camera-outline"></ion-icon>
                Absen Masuk
            </button>
        @endif
    </div>
</div>

<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
@endsection

@push('myscript')
<script>
$(document).ready(function () {
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.attach('.webcam-capture');

    var lokasiInput = document.getElementById('lokasi');

    var kantor_lat = -3.759550715621518;
    var kantor_long = 102.2727694796255;
    var radiuskantor = {{ $radiuskantor }};

    var map = L.map('map').setView([kantor_lat, kantor_long], 16);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    var circle = L.circle([kantor_lat, kantor_long], {
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.3,
        radius: radiuskantor
    }).addTo(map);

    
    setTimeout(function () {
        map.invalidateSize();
        map.fitBounds(circle.getBounds());
    }, 500);

    var markerUser;

    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(function (position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            lokasiInput.value = latitude + "," + longitude;

            if (markerUser) {
                markerUser.setLatLng([latitude, longitude]);
            } else {
                markerUser = L.marker([latitude, longitude])
                    .addTo(map)
                    .bindPopup("Lokasi Anda");
            }
        }, function (error) {
            Swal.fire({
                title: 'Lokasi Gagal',
                text: error.message,
                icon: 'error'
            });
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    }

    $("#takeabsen").click(function (e) {
        e.preventDefault();

        var lokasi = $("#lokasi").val();

        if (lokasi == "") {
            Swal.fire({
                title: 'Lokasi belum terbaca',
                text: 'Tunggu beberapa detik sampai GPS aktif.',
                icon: 'warning'
            });
            return;
        }

        Webcam.snap(function (uri) {
            $.ajax({
                type: "POST",
                url: "{{ url('/presensi/store') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    image: uri,
                    lokasi: lokasi
                },
                success: function (respond) {
                    var status = respond.split("|");

                    if (status[0] == "success") {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: status[1],
                            icon: 'success'
                        });

                        setTimeout(function () {
                            window.location.href = "/dashboard";
                        }, 3000);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error'
                        });
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);

                    Swal.fire({
                        title: 'Server Error',
                        text: 'Terjadi kesalahan pada server.',
                        icon: 'error'
                    });
                }
            });
        });
    });
});
</script>
@endpush
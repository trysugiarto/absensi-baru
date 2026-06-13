<!-- App Bottom Menu -->
<div class="appBottomMenu">

    <a href="{{ url('/dashboard') }}" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home-outline"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>

    <a href="{{ url('/calendar') }}" class="item {{ request()->is('calendar') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar-outline"></ion-icon>
            <strong>Calendar</strong>
        </div>
    </a>

    <a href="/presensi/create" class="item">
        <div class="col">
            <div class="action-button large">
                <ion-icon name="camera-outline"></ion-icon>
            </div>
        </div>
    </a>

    <a href="{{ url('/laporan') }}" class="item {{ request()->is('laporan') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text-outline"></ion-icon>
            <strong>Laporan</strong>
        </div>
    </a>

    <a href="{{ url('/editprofile') }}" class="item {{ request()->is('editprofile') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="people-outline"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>

</div>
<!-- * App Bottom Menu -->
@extends('layouts.absensi')

@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>

    <div class="pageTitle">Calendar</div>

    <div class="right"></div>
</div>>
@endsection

@section('content')

<style>
    .calendar-section{
        margin-top:15px;
        margin-bottom:90px;
    }

    .filter-card{
        border-radius:15px;
        margin-bottom:10px;
        box-shadow:0 3px 8px rgba(0,0,0,0.12);
    }

    .filter-card .card-body{
        padding:12px;
    }

    .filter-row{
        display:flex;
        gap:8px;
        align-items:center;
    }

    .filter-box{
        width:50%;
        height:36px;
        border:1px solid #ddd;
        border-radius:7px;
        padding:0 10px;
        font-size:12px;
        color:#555;
        background:#fff;
    }

    .legend{
        display:flex;
        gap:9px;
        font-size:10px;
        margin-top:10px;
        flex-wrap:wrap;
        align-items:center;
    }

    .legend span{
        display:inline-flex;
        align-items:center;
        gap:4px;
    }

    .box-red,
    .box-green{
        width:8px;
        height:8px;
        border-radius:50%;
        display:inline-block;
    }

    .box-red{
        background:#dc2626;
    }

    .box-green{
        background:#16a34a;
    }

    /* SCROLL AREA KOTAK HITAM */
    #calendarScroll{
        height:610px;
        overflow-y:auto;
        overflow-x:hidden;
        background:#fff;
        padding:6px;
        border-radius:5px;
    }

    #calendarScroll::-webkit-scrollbar{
        width:6px;
    }

    #calendarScroll::-webkit-scrollbar-track{
        background:#e5e7eb;
        border-radius:10px;
    }

    #calendarScroll::-webkit-scrollbar-thumb{
        background:#2563eb;
        border-radius:10px;
    }

    #calendarScroll::-webkit-scrollbar-thumb:hover{
        background:#1d4ed8;
    }

    .calendar-grid{
        display:grid;
        grid-template-columns:repeat(2, 1fr);
        gap:6px;
    }

    .calendar-card{
        border-radius:9px;
        overflow:hidden;
        box-shadow:0 2px 5px rgba(0,0,0,0.08);
        background:white;
    }

    .calendar-title{
        background:#047857;
        color:white;
        padding:5px 4px;
        text-align:center;
        font-weight:bold;
        font-size:9px;
    }

    .calendar-table{
        width:100%;
        margin-bottom:0;
        text-align:center;
        font-size:7px;
    }

    .calendar-table th{
        background:#f1f5f9;
        padding:2px;
        font-size:6.5px;
    }

    .calendar-table td{
        height:14px;
        width:14px;
        padding:1px;
        vertical-align:middle;
    }

    .day-number{
        display:inline-block;
        min-width:12px;
        height:12px;
        line-height:12px;
        border-radius:50%;
        font-size:6.5px;
    }

    .today{
        background:#16a34a;
        color:white;
        font-weight:bold;
    }

    .holiday{
        background:#dc2626;
        color:white;
        font-weight:bold;
    }

    .sunday{
        color:#dc2626;
        font-weight:bold;
    }
</style>

<div class="section calendar-section">

    <div class="card filter-card">
        <div class="card-body">

            <div class="filter-row">

                <select id="pilihBulan" class="filter-box">
                    <option value="">Bulan</option>
                    <option value="0">Januari</option>
                    <option value="1">Februari</option>
                    <option value="2">Maret</option>
                    <option value="3">April</option>
                    <option value="4">Mei</option>
                    <option value="5">Juni</option>
                    <option value="6">Juli</option>
                    <option value="7">Agustus</option>
                    <option value="8">September</option>
                    <option value="9">Oktober</option>
                    <option value="10">November</option>
                    <option value="11">Desember</option>
                </select>

                <select id="pilihTahun" class="filter-box">
                    <option value="">Tahun</option>

                    @for($y = 2020; $y <= 2030; $y++)
                        <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                </select>

            </div>

            <div class="legend">
                <span>
                    <i class="box-green"></i>
                    Hari Ini
                </span>

                <span>
                    <i class="box-red"></i>
                    Libur Nasional
                </span>

                <span style="color:#dc2626; font-weight:bold;">
                    Minggu
                </span>
            </div>

        </div>
    </div>

    <!-- SCROLL HANYA DI KOTAK INI -->
    <div id="calendarScroll">
        <div id="calendarContainer" class="calendar-grid"></div>
    </div>

</div>

<script>
const bulanNama = [
    "Januari", "Februari", "Maret", "April",
    "Mei", "Juni", "Juli", "Agustus",
    "September", "Oktober", "November", "Desember"
];

const hariNama = [
    "Min", "Sen", "Sel", "Rab",
    "Kam", "Jum", "Sab"
];

const today = new Date();

let holidays = {};
let allCalendars = [];

async function ambilHariLibur(){
    holidays = {};

    for(let tahun = 2020; tahun <= 2030; tahun++){
        try{
            const response = await fetch(
                `https://date.nager.at/api/v3/PublicHolidays/${tahun}/ID`
            );

            const data = await response.json();

            data.forEach(item => {
                holidays[item.date] = item.localName;
            });

        }catch(error){
            console.log("Gagal mengambil hari libur tahun " + tahun);
        }
    }

    tampilkanSemuaKalender();
}

function buatKalender(tahun, bulan){
    const hariPertama = new Date(tahun, bulan, 1).getDay();
    const jumlahHari = new Date(tahun, bulan + 1, 0).getDate();

    let tanggal = 1;
    let html = "";

    html += `
        <div class="month-wrapper"
             data-tahun="${tahun}"
             data-bulan="${bulan}">

            <div class="calendar-card">

                <div class="calendar-title">
                    ${bulanNama[bulan]} ${tahun}
                </div>

                <table class="table calendar-table table-bordered">
                    <thead>
                        <tr>
    `;

    hariNama.forEach((hari, index) => {
        let warna = index === 0 ? 'style="color:#dc2626;"' : "";
        html += `<th ${warna}>${hari}</th>`;
    });

    html += `
                        </tr>
                    </thead>
                    <tbody>
    `;

    for(let i = 0; i < 6; i++){
        html += "<tr>";

        for(let j = 0; j < 7; j++){
            if(i === 0 && j < hariPertama){
                html += "<td></td>";
            }else if(tanggal > jumlahHari){
                html += "<td></td>";
            }else{
                let tanggalFull =
                    `${tahun}-${String(bulan + 1).padStart(2, '0')}-${String(tanggal).padStart(2, '0')}`;

                let className = "day-number";
                let title = "";

                if(j === 0){
                    className += " sunday";
                    title = "Minggu";
                }

                if(holidays[tanggalFull]){
                    className += " holiday";
                    title = holidays[tanggalFull];
                }

                if(
                    tanggal === today.getDate() &&
                    bulan === today.getMonth() &&
                    tahun === today.getFullYear()
                ){
                    className += " today";
                    title = "Hari Ini";
                }

                html += `
                    <td>
                        <span class="${className}" title="${title}">
                            ${tanggal}
                        </span>
                    </td>
                `;

                tanggal++;
            }
        }

        html += "</tr>";

        if(tanggal > jumlahHari){
            break;
        }
    }

   let daftarLibur = "";

Object.keys(holidays).forEach(function(tgl){
    let date = new Date(tgl);

    if(date.getFullYear() === tahun && date.getMonth() === bulan){
        daftarLibur += `
            <div style="
                font-size:7px;
                color:#dc2626;
                padding:1px 5px;
                line-height:10px;
                font-weight:bold;
            ">
                ${date.getDate()} - ${holidays[tgl]}
            </div>
        `;
    }
});

if(daftarLibur === ""){
    daftarLibur = `
        <div style="
            font-size:7px;
            color:#64748b;
            padding:2px 5px;
            line-height:10px;
        ">
            Tidak ada libur nasional
        </div>
    `;
}

html += `
                    </tbody>
                </table>

                <div style="
                    border-top:1px solid #e5e7eb;
                    background:#fff;
                    padding:3px 0;
                    min-height:18px;
                ">
                    ${daftarLibur}
                </div>

            </div>
        </div>
    `;

    return html;
}

function tampilkanSemuaKalender(){
    let html = "";

    for(let tahun = 2020; tahun <= 2030; tahun++){
        for(let bulan = 0; bulan < 12; bulan++){
            html += buatKalender(tahun, bulan);
        }
    }

    document.getElementById("calendarContainer").innerHTML = html;
    allCalendars = document.querySelectorAll(".month-wrapper");
}

function filterKalender(){
    const bulanPilih = document.getElementById("pilihBulan").value;
    const tahunPilih = document.getElementById("pilihTahun").value;

    allCalendars.forEach(item => {
        const tahun = item.getAttribute("data-tahun");
        const bulan = item.getAttribute("data-bulan");

        const cocokBulan =
            bulanPilih === "" ||
            bulan === bulanPilih;

        const cocokTahun =
            tahunPilih === "" ||
            tahun === tahunPilih;

        item.style.display =
            (cocokBulan && cocokTahun) ? "block" : "none";
    });
}

document.getElementById("pilihBulan")
    .addEventListener("change", filterKalender);

document.getElementById("pilihTahun")
    .addEventListener("change", filterKalender);

ambilHariLibur();
</script>

@endsection
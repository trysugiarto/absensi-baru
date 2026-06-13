<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PresensiController extends Controller
{
    private $radiuskantor = 480;

    public function create()
    {
        $hariini = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->where('nik', $nik)
            ->count();

        $radiuskantor = $this->radiuskantor;

        return view('presensi.create', compact('cek', 'radiuskantor'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $jam = Carbon::now('Asia/Jakarta')->format('H:i:s');

        $latitudekantor = -3.759550715621518;
        $longitudekantor = 102.2727694796255;

        $lokasi = $request->lokasi;
        $image = $request->image;

        if (!$lokasi) {
            return response("error|Lokasi belum terbaca");
        }

        if (!$image) {
            return response("error|Foto belum diambil");
        }

        $lokasiuser = explode(",", $lokasi);

        if (count($lokasiuser) < 2) {
            return response("error|Format lokasi tidak valid");
        }

        $latitudeuser = (float) $lokasiuser[0];
        $longitudeuser = (float) $lokasiuser[1];

        $jarak = $this->distance(
            $latitudekantor,
            $longitudekantor,
            $latitudeuser,
            $longitudeuser
        );

        $radius = round($jarak["meters"]);

        if ($radius > $this->radiuskantor) {
            return response("error|Maaf Anda Berada Diluar Radius, jarak Anda " . $radius . " meter");
        }

        $image_parts = explode(";base64,", $image);

        if (count($image_parts) < 2) {
            return response("error|Foto gagal diambil");
        }

        $image_base64 = base64_decode($image_parts[1]);

        $folderPath = "uploads/absensi/";

        $cek = DB::table('presensi')
            ->where('tgl_presensi', $tgl_presensi)
            ->where('nik', $nik)
            ->count();

        if ($cek > 0) {
            $jamSekarang = Carbon::now('Asia/Jakarta')->format('H:i');

            if ($jamSekarang < '15:50') {
                return response("error|Absen pulang dibuka jam 15:50 WIB");
            }

            if ($jamSekarang > '17:30') {
                return response("error|Absen pulang sudah ditutup jam 17:30 WIB");
            }

            $presensi = DB::table('presensi')
                ->where('tgl_presensi', $tgl_presensi)
                ->where('nik', $nik)
                ->first();

            if ($presensi->jam_out != null) {
                return response("error|Anda sudah absen pulang hari ini");
            }

            $fileName = $nik . "-" . $tgl_presensi . "-out.png";
            $file = $folderPath . $fileName;

            $data_pulang = [
                'jam_out' => $jam,
                'foto_out' => $fileName,
                'lokasi_out' => $lokasi,
            ];

            $update = DB::table('presensi')
                ->where('tgl_presensi', $tgl_presensi)
                ->where('nik', $nik)
                ->update($data_pulang);

            if ($update) {
                Storage::disk('public')->put($file, $image_base64);
                return response("success|Terimakasih, Hati-Hati Dijalan|out");
            }

            return response("error|Maaf Gagal Absen");
        }

        $jamMasuk = Carbon::now('Asia/Jakarta')->format('H:i');

        if ($jamMasuk < '06:00') {
            return response("error|Absen masuk dibuka jam 06.00 WIB");
        }

        $fileName = $nik . "-" . $tgl_presensi . "-in.png";
        $file = $folderPath . $fileName;

        $keterangan = null;

        if ($jamMasuk > '08:00') {
            $keterangan = "Terlambat";
        }

        $data = [
            'nik' => $nik,
            'tgl_presensi' => $tgl_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'lokasi_in' => $lokasi,
            'keterangan_in' => $keterangan,
        ];

        $simpan = DB::table('presensi')->insert($data);

        if ($simpan) {
            Storage::disk('public')->put($file, $image_base64);
            return response("success|Terimakasih Selamat Bekerja|in");
        }

        return response("error|Maaf Gagal Absen");
    }

    private function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;

        $miles = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));

        $miles = acos(min(max($miles, -1), 1));
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;

        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;

        return compact('meters');
    }

    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        $karyawan = DB::table('karyawan')
            ->where('nik', $nik)
            ->first();

        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'no_hp' => 'required',
            'password' => 'nullable|min:3',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $nik = Auth::guard('karyawan')->user()->nik;

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'no_hp' => $request->no_hp,
        ];

        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
            $data['foto'] = $foto;

            $request->file('foto')->storeAs('public/uploads/karyawan/', $foto);
        }

        DB::table('karyawan')
            ->where('nik', $nik)
            ->update($data);

        return redirect()->back()->with('success', 'Data Berhasil Di Update');
    }

    public function laporan(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $historibulanini = DB::table('presensi')
            ->where('nik', $nik)
            ->whereMonth('tgl_presensi', $bulan)
            ->whereYear('tgl_presensi', $tahun)
            ->orderBy('tgl_presensi', 'desc')
            ->get();

        return view('presensi.laporan', compact(
            'historibulanini',
            'bulan',
            'tahun'
        ));
    }

    public function exportpdf(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $karyawan = DB::table('karyawan')
            ->where('nik', $nik)
            ->first();

        $historibulanini = DB::table('presensi')
            ->where('nik', $nik)
            ->whereMonth('tgl_presensi', $bulan)
            ->whereYear('tgl_presensi', $tahun)
            ->orderBy('tgl_presensi', 'asc')
            ->get();

        $pdf = Pdf::loadView(
            'presensi.laporanpdf',
            compact(
                'historibulanini',
                'karyawan',
                'bulan',
                'tahun'
            )
        )->setPaper('a4', 'landscape');

        return $pdf->download(
            'Laporan-E-Absensi-' . $bulan . '-' . $tahun . '.pdf'
        );
    }
}
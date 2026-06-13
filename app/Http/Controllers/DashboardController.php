<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $bulanini = Carbon::now('Asia/Jakarta')->format('m');

        $nik = Auth::guard('karyawan')->user()->nik;

        $presensihariini = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->where('nik', $nik)
            ->first();

        $historibulanini = DB::table('presensi')
            ->where('nik', $nik)
            ->whereMonth('tgl_presensi', $bulanini)
            ->orderBy('tgl_presensi', 'desc')
            ->get();

        return view('dashboard.dashboard', compact(
            'presensihariini',
            'historibulanini'
        ));
    }

    public function admin()
    {
        $hariini = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $jumlahkaryawan = DB::table('karyawan')->count();

        $hadirhariini = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->count();

        $terlambat = DB::table('presensi')
            ->where('tgl_presensi', $hariini)
            ->where('keterangan_in', 'Terlambat')
            ->count();

        $belumabsen = $jumlahkaryawan - $hadirhariini;

        return view('admin.dashboard', compact(
            'jumlahkaryawan',
            'hadirhariini',
            'terlambat',
            'belumabsen'
        ));
    }

    public function karyawan(Request $request)
    {
        $query = DB::table('karyawan');

        if ($request->search) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nik', 'like', '%' . $request->search . '%');
        }

        $karyawan = $query
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        return view('admin.karyawan', compact('karyawan'));
    }

    public function tambahkaryawan()
    {
        return view('admin.tambahkaryawan');
    }

    public function storekaryawan(Request $request)
    {
        DB::table('karyawan')->insert([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'foto' => 'default.png',
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return redirect('/admin/karyawan');
    }

    public function editkaryawan($nik)
    {
        $karyawan = DB::table('karyawan')
            ->where('nik', $nik)
            ->first();

        return view('admin.editkaryawan', compact('karyawan'));
    }

     public function updatekaryawan(Request $request, $nik)
    {
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan'      => $request->jabatan,
            'no_hp'        => $request->no_hp,
            'role'         => $request->role
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        DB::table('karyawan')
            ->where('nik', $nik)
            ->update($data);

        return redirect('/admin/karyawan');
    }

    public function deletekaryawan($nik)
    {
        DB::table('karyawan')
            ->where('nik', $nik)
            ->delete();

        return redirect('/admin/karyawan');
    }

    public function rekap(Request $request)
{
    $bulan = $request->bulan ?? date('m');
    $tahun = $request->tahun ?? date('Y');

    $rekap = DB::table('presensi')
        ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        ->select(
            'presensi.*',
            'karyawan.nama_lengkap',
            'karyawan.jabatan'
        )
        ->whereMonth('tgl_presensi', $bulan)
        ->whereYear('tgl_presensi', $tahun)
        ->orderBy('tgl_presensi', 'desc')
        ->get();

      return view('admin.rekap', compact(
        'rekap',
        'bulan',
        'tahun'
    ));
}
public function exportpdfrekap(Request $request)
{
    $bulan = $request->bulan ?? date('m');
    $tahun = $request->tahun ?? date('Y');

    $rekap = DB::table('presensi')
        ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        ->select(
            'presensi.*',
            'karyawan.nama_lengkap',
            'karyawan.jabatan'
        )
        ->whereMonth('tgl_presensi', $bulan)
        ->whereYear('tgl_presensi', $tahun)
        ->orderBy('tgl_presensi', 'desc')
        ->get();

    $pdf = Pdf::loadView(
        'admin.rekappdf',
        compact('rekap', 'bulan', 'tahun')
    )->setPaper('A4', 'portrait');

     return $pdf->download('rekap-absensi.pdf');
}
}
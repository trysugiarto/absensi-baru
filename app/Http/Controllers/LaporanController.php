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
    )->setPaper('a4', 'portrait');

    return $pdf->download(
        'Laporan-E-Absensi-' . $bulan . '-' . $tahun . '.pdf'
    );
}
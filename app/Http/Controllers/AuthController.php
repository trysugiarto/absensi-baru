<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect('/');
        }

        if (Auth::guard('karyawan')->attempt([
            'nik' => $request->nik,
            'password' => $request->password
        ])) {

            $request->session()->regenerate();

            $user = Auth::guard('karyawan')->user();

            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/dashboard');
        }

        return redirect('/')
            ->with('warning', 'NIK / Password Salah');
    }

    public function logout(Request $request)
    {
        Auth::guard('karyawan')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function proseslogout(Request $request)
    {
        return $this->logout($request);
    }
}
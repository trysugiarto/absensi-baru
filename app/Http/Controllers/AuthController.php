<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {

        if (Auth::guard('karyawan')->attempt([
            'nik' => $request->nik,
            'password' => $request->password
        ])) {

            $user = Auth::guard('karyawan')->user();

            // LOGIN ADMIN
            if ($user->role == 'admin') {

                return redirect('/admin/dashboard');
            }

            // LOGIN KARYAWAN
            return redirect('/dashboard');
        }

        return redirect('/')
            ->with('warning', 'NIK / Password Salah');
    }

    public function logout()
    {
        Auth::guard('karyawan')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function proseslogout()
    {
        return $this->logout();
    }
}
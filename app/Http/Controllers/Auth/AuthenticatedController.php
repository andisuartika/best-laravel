<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticatedController extends Controller
{
    public function login()
    {
        // Cek Login
        if (Auth::check()) {
            // Cek role
            if (Auth::user()->role == 'ADMIN DESA') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/super-admin/dashboard');
            }
            return redirect('login');
        }
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required',
        ]);

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // CEK LOGIN
        if (Auth::attempt($login)) {
            $user = Auth::getProvider()->retrieveByCredentials($login);
            if (Auth::user()->role == 'ADMIN DESA') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/super-admin/dashboard');
            }
        } else {
            // Auth Gagal
            return back()->withErrors([
                'message' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }
    }


    public function logout()
    {
        Session::flush();

        Auth::logout();

        return  redirect()->route('login');
    }
}

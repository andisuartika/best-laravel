<?php

namespace App\Http\Controllers\Auth;

use App\Rules\ReCaptcha;
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
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required',
            // 'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // CEK LOGIN
        if (Auth::attempt($login)) {
            $user = Auth::getProvider()->retrieveByCredentials($login);
            return redirect('/dashboard');
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

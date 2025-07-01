<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function showRegisterForm()
    {
        return view('mobile.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'required|unique:users',
            'usia' => 'required|numeric',
            'alamat' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'onesignal_id' => 'nullable|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'usia' => $request->usia,
            'alamat' => $request->alamat,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 2,
            'foto' => 'user.jpg',
            'onesignal_id' => $request->onesignal_id,
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }

    public function showLoginForm()
    {
        return view('mobile.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Login gagal.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

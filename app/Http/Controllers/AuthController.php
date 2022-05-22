<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Login
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required'
            ],
            'password' => [
                'required'
            ]
        ], [], [
            'email' => 'alamat email',
            'password' => 'kata sandi'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return Redirect::intended(route('page.home'))->with('alert', [
                'text' => 'Berhasil masuk'
            ]);
        }

        return Redirect::route('auth.login')->with('loginError', 'Alamat email atau password salah !')->onlyInput('email');
    }

    // Register
    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'alpha_spaces',
                'min:5',
                'max:' . Builder::$defaultStringLength
            ],
            'username' => [
                'required',
                'alpha_num',
                'unique:users,username',
                'min:5',
                'max:50'
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'confirmed',
                'min:5',
                'max:' . Builder::$defaultStringLength
            ]
        ], [], [
            'name' => 'nama',
            'username' => 'nama pengguna',
            'email' => 'alamat email',
            'password' => 'kata sandi'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        return Redirect::intended(route('page.home'))->with('alert', [
            'text' => 'Berhasil mendaftar'
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::intended(route('page.home'))->with('alert', [
            'text' => 'Berhasil keluar'
        ]);
    }
}

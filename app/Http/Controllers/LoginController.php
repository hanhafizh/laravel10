<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login_proses(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password Salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Kamu berhasil Logout');
    }

    public function register()
    {
        return view('register');
    }

    public function register_proses(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        User::create($data);

        $register = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($register)) {
            return redirect()->route('admin.dashboard')->with('success_register_user', 'Berhasil membuat akun!');
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password Salah');
        }
    }
}

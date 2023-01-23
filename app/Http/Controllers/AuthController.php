<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        //cek login valid atau tidak 
        if (Auth::attempt($credentials)){
            // cek kalau status user aktif
            if(Auth::user()->status != 'active'){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                Session::flash('status', 'failed');
                Session::flash('message', 'Maaf Akun Anda Belum Aktif, Kontak Admin Untuk Lebih Lanjut');
                return redirect('/login');
            }
            // $request->session()->regenerate(
            if(Auth::user()->role_id == 1){
                return redirect('dashboard');
            }

            if(Auth::user()->role_id == 2){
                return redirect('profile');
            }
        }
        //Jika credentials tidak cocok atau tidak ada
        Session::flash('status', 'failed');
        Session::flash('message', 'Login Invalid');
        return redirect('/login');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function registerProcess(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:users|max:255',
            'password' => 'required|max:25|min:5',
            'phone'    => 'max:25',
            'address'  => 'required',
        ]);
        //Registration process + encrypting password with hash
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());
        
        Session::flash('status', 'success');
        Session::flash('message', 'Register success, Please wait for approval');
        return redirect('register');
    }
}



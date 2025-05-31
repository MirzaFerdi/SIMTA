<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        if(Auth::check()){
            $jumlahMahasiswa = User::where('role_id', 3)->count();
            $jumlahDosen = User::where('role_id', 2)->count();
            return view('dashboard', compact('jumlahMahasiswa', 'jumlahDosen'));
        }
        return redirect()->route('auth.login', );
    }

    public function login(Request $request){
        $credentials = $request->only('username', 'password');

        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}

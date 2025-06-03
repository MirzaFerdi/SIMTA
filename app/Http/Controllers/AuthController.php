<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bimbingan;

class AuthController extends Controller
{
    public function index(){
        if(Auth::check()){
            $jumlahMahasiswa = User::where('role_id', 3)->count();
            $jumlahDosen = User::where('role_id', 2)->count();
            $bimbinganMajuSempro = Bimbingan::where('status', 'Maju Sempro')->get();

            $pengusulIds = collect();
            foreach ($bimbinganMajuSempro as $bimbingan) {
                if ($bimbingan->pengusul1) {
                    $pengusulIds->push($bimbingan->pengusul1);
                }
                if ($bimbingan->pengusul2) {
                    $pengusulIds->push($bimbingan->pengusul2);
                }
            }
            $pengusulIds = $pengusulIds->unique();

            $mhsSudahSeminar = User::where('role_id', 3)
                ->whereIn('id', $pengusulIds)
                ->count();

            $mhsBelumSeminar = User::where('role_id', 3)
                ->whereNotIn('id', $pengusulIds)
                ->count();

            return view('dashboard', compact('jumlahMahasiswa', 'jumlahDosen', 'mhsSudahSeminar', 'mhsBelumSeminar'));
        }
        return redirect()->route('auth.login', );
    }

    public function login(Request $request){
        $login = $request->input('username');
        $password = $request->input('password');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bimbingan;
use App\Models\PengajuanJudul;
use App\Models\BeritaAcara;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $jumlahMahasiswa = User::where('role_id', 3)->count();
            $jumlahDosen = User::where('role_id', 2)->count();
            $bimbinganMajuSempro = Bimbingan::where('status', 'Maju Sempro')->get();

            $mahasiswaIds = collect();
            foreach ($bimbinganMajuSempro as $bimbingan) {
                if ($bimbingan->mahasiswa1) {
                    $mahasiswaIds->push($bimbingan->mahasiswa1);
                }
                if ($bimbingan->mahasiswa2) {
                    $mahasiswaIds->push($bimbingan->mahasiswa2);
                }
            }
            $mahasiswaIds = $mahasiswaIds->unique();

            $beritaAcaras = BeritaAcara::all();
            $mahasiswaSeminarIds = collect();

            foreach ($beritaAcaras as $ba) {
                if ($ba->mahasiswa1) {
                    $mahasiswaSeminarIds->push($ba->mahasiswa1);
                }
                if ($ba->mahasiswa2) {
                    $mahasiswaSeminarIds->push($ba->mahasiswa2);
                }
            }
            $mahasiswaSeminarIds = $mahasiswaSeminarIds->unique();

            $mhsSudahSeminar = User::where('role_id', 3)
                ->whereIn('id', $mahasiswaSeminarIds)
                ->count();

            $mhsBelumSeminar = User::where('role_id', 3)
                ->whereNotIn('id', $mahasiswaIds)
                ->count();

            // Make sure you have defined 'pengajuanJudul1' and 'pengajuanJudul2' relationships in the Bimbingan model
            $mahasiswaBimbingan1 = Bimbingan::where('dospem1', Auth::user()->id)
                ->where('status', '!=', 'Maju Sempro')
                ->with('pengajuanJudul1')
                ->get();

            $mahasiswaBimbingan2 = Bimbingan::where('dospem2', Auth::user()->id)
                ->where('status', '!=', 'Maju Sempro')
                ->with('pengajuanJudul2')
                ->get();

            // Filter hanya bimbingan di mana dosen benar-benar sebagai dospem1 atau dospem2
            $mahasiswaBimbingan1 = $mahasiswaBimbingan1->filter(function ($bimbingan) {
                return $bimbingan->mahasiswa1 !== null;
            })->unique('mahasiswa1')->values();

            $mahasiswaBimbingan2 = $mahasiswaBimbingan2->filter(function ($bimbingan) {
                return $bimbingan->mahasiswa2 !== null;
            })->unique('mahasiswa2')->values();

            return view('dashboard', compact(
                'jumlahMahasiswa',
                'jumlahDosen',
                'mhsSudahSeminar',
                'mhsBelumSeminar',
                'mahasiswaBimbingan1',
                'mahasiswaBimbingan2'
            ));
        }
        return redirect()->route('auth.login',);
    }

    public function login(Request $request)
    {
        $login = $request->input('username');
        $password = $request->input('password');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->with('error', 'Username atau Password anda salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

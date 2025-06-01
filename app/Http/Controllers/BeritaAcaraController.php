<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PengajuanJudul;

class BeritaAcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = User::where('role_id', 3)->get();
        $dosen = User::where('role_id', 2)->get();
        $pengajuan = PengajuanJudul::where('status', 'Diterima')->get();
        $beritaAcara = BeritaAcara::with(['pengusul1BeritaAcara', 'pengusul2BeritaAcara', 'dosenBeritaAcara', 'pengajuanBeritaAcara'])
            ->get();

        return view('beritaAcara', compact('beritaAcara', 'mahasiswa', 'dosen', 'pengajuan'));
    }

    public function rekapSeminar()
    {
        $user = auth()->user();

        if ($user->role_id == 1) {
            // Admin: ambil semua rekap seminar
            $rekapSeminar = BeritaAcara::with(['pengusul1BeritaAcara', 'pengusul2BeritaAcara', 'dosenBeritaAcara', 'pengajuanBeritaAcara'])
            ->get();
        } elseif ($user->role_id == 2) {
            // Dosen: ambil rekap seminar yang dosennya adalah user ini
            $rekapSeminar = BeritaAcara::with(['pengusul1BeritaAcara', 'pengusul2BeritaAcara', 'dosenBeritaAcara', 'pengajuanBeritaAcara'])
            ->where('dosen', $user->id)
            ->get();
        } elseif ($user->role_id == 3) {
            // Mahasiswa: ambil rekap seminar yang pengusul1 atau pengusul2 adalah user ini
            $rekapSeminar = BeritaAcara::with(['pengusul1BeritaAcara', 'pengusul2BeritaAcara', 'dosenBeritaAcara', 'pengajuanBeritaAcara'])
            ->where(function ($query) use ($user) {
                $query->where('pengusul1', $user->id)
                  ->orWhere('pengusul2', $user->id);
            })
            ->get();
        } else {
            $rekapSeminar = collect();
        }

        return view('rekapSeminar', compact('rekapSeminar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pengusul1' => 'required|exists:users,id',
            'pengusul2' => 'nullable|exists:users,id',
            'dosen' => 'required|exists:users,id',
            'pengajuan_id' => 'required|exists:pengajuan_juduls,id',
            'berita_acara' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $beritaAcara = new BeritaAcara();
        $beritaAcara->pengusul1 = $request->pengusul1;
        $beritaAcara->pengusul2 = $request->pengusul2;
        $beritaAcara->dosen = $request->dosen;
        $beritaAcara->pengajuan_id = $request->pengajuan_id;
        if ($request->hasFile('berita_acara')) {
            $filename = time() . '_' . $request->file('berita_acara')->getClientOriginalName();
            $request->file('berita_acara')->storeAs('public/file/berita-acara', $filename);
            $beritaAcara->berita_acara = $filename;
        }
        $beritaAcara->save();

        return redirect()->route('berita-acara')->with('success', 'Berita Acara created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BeritaAcara $beritaAcara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BeritaAcara $beritaAcara)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BeritaAcara $beritaAcara)
    {
        $request->validate([
            'pengusul1' => 'required|exists:users,id',
            'pengusul2' => 'nullable|exists:users,id',
            'dosen' => 'required|exists:users,id',
            'pengajuan_id' => 'required|exists:pengajuan_juduls,id',
            'berita_acara' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $beritaAcara->pengusul1 = $request->pengusul1;
        $beritaAcara->pengusul2 = $request->pengusul2;
        $beritaAcara->dosen = $request->dosen;
        $beritaAcara->pengajuan_id = $request->pengajuan_id;

        if ($request->hasFile('berita_acara')) {
            // Hapus file lama jika ada
            if ($beritaAcara->berita_acara) {
                Storage::delete('public/file/berita-acara/' . $beritaAcara->berita_acara);
            }
            $filename = time() . '_' . $request->file('berita_acara')->getClientOriginalName();
            $request->file('berita_acara')->storeAs('public/file/berita-acara', $filename);
            $beritaAcara->berita_acara = $filename;
        }

        $beritaAcara->save();

        return redirect()->route('berita-acara')->with('success', 'Berita Acara updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BeritaAcara $beritaAcara)
    {
        $beritaAcara->delete();
        return redirect()->route('berita-acara')->with('success', 'Berita Acara deleted successfully.');
    }
}

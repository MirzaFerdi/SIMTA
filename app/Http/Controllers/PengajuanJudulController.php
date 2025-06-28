<?php

namespace App\Http\Controllers;

use App\Models\PengajuanJudul;
use App\Models\User;
use Illuminate\Http\Request;

class PengajuanJudulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuanJudul = PengajuanJudul::all();
        $mahasiswa = User::where('role_id', '3')->get();
        $dosen = User::where('role_id', '2')->get();
        $userId = auth()->id();
        if (auth()->user()->role_id == 3) {
            $pengajuanUser = PengajuanJudul::where('pengusul1', $userId)
            ->orWhere('pengusul2', $userId)
            ->get();
        } else {
            $pengajuanUser = collect();
        }

        $bolehTambah = false;
        if (auth()->user()->role_id == 3) {
            $terakhir = $pengajuanUser->last();
            $bolehTambah = $pengajuanUser->isEmpty() ||
                ($terakhir && in_array($terakhir->status, ['Diproses', 'Ditolak']));
        }

        return view('pengajuanJudul', compact('pengajuanJudul', 'mahasiswa', 'pengajuanUser', 'bolehTambah', 'dosen'));
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
            'tahun' => 'required',
            'judul' => 'required',
            'pengusul1' => 'required',
            'pengusul2' => 'required',
            'dospem1' => 'exists:users,id',
            'dospem2' => 'exists:users,id',
        ]);
        $pengajuanJudul = new PengajuanJudul();
        $pengajuanJudul->tahun = $request->tahun;
        $pengajuanJudul->judul = $request->judul;
        $pengajuanJudul->pengusul1 = $request->pengusul1;
        $pengajuanJudul->pengusul2 = $request->pengusul2;
        $pengajuanJudul->dospem1 = $request->dospem1;
        $pengajuanJudul->dospem2 = $request->dospem2;
        $pengajuanJudul->status = 'Diproses';
        $pengajuanJudul->save();
        return redirect()->route('pengajuan')->with('success', 'Pengajuan Judul Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(PengajuanJudul $pengajuanJudul)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanJudul $pengajuanJudul)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanJudul $pengajuanJudul)
    {
        $request->validate([
            'tahun' => 'required',
            'judul' => 'required',
            'pengusul1' => 'required',
            'pengusul2' => 'required',
            'dospem1' => 'exists:users,id',
            'dospem2' => 'exists:users,id',
        ]);
        $pengajuanJudul->tahun = $request->tahun;
        $pengajuanJudul->judul = $request->judul;
        $pengajuanJudul->pengusul1 = $request->pengusul1;
        $pengajuanJudul->pengusul2 = $request->pengusul2;
        $pengajuanJudul->dospem1 = $request->dospem1;
        $pengajuanJudul->dospem2 = $request->dospem2;
        $pengajuanJudul->status = 'Diproses';
        $pengajuanJudul->save();
        return redirect()->route('pengajuan')->with('success', 'Pengajuan Judul Berhasil Diupdate');
    }

    public function updateStatus(Request $request, PengajuanJudul $pengajuanJudul)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
        ]);
        $pengajuanJudul->status = $request->status;
        $pengajuanJudul->save();
        return redirect()->route('pengajuan')->with('success', 'Status Pengajuan Judul Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanJudul $pengajuanJudul)
    {
        $pengajuanJudul->delete();
        return redirect()->route('pengajuan')->with('success', 'Pengajuan Judul Berhasil Dihapus');
    }
}

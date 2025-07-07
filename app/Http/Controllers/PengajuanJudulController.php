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
            $pengajuanUser = PengajuanJudul::where('mahasiswa1', $userId)
            ->orWhere('mahasiswa2', $userId)
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

    public function indexDospem(){
        $dospems = PengajuanJudul::with(['mahasiswa1Pengajuan', 'mahasiswa2Pengajuan', 'dospem1Pengajuan', 'dospem2Pengajuan'])
            ->where('status', 'Disetujui')
            ->get();
        $dosen = User::where('role_id', '2')->get();
        return view('dospem', compact('dospems', 'dosen'));
    }

    public function updateDospem(Request $request, PengajuanJudul $pengajuanJudul)
    {
        $request->validate([
            'dospem1' => 'exists:users,id',
            'dospem2' => 'nullable|exists:users,id',
        ]);
        $pengajuanJudul->dospem1 = $request->dospem1;
        $pengajuanJudul->dospem2 = $request->dospem2;
        $pengajuanJudul->save();
        return redirect()->route('dospem')->with('success', 'Dosen Pembimbing Berhasil Diupdate');
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
            'mahasiswa1' => 'required',
            'mahasiswa2' => 'required',
            'dospem1' => 'exists:users,id',
            'dospem2' => 'nullable|exists:users,id',
        ]);
        $pengajuanJudul = new PengajuanJudul();
        $pengajuanJudul->tahun = $request->tahun;
        $pengajuanJudul->judul = $request->judul;
        $pengajuanJudul->mahasiswa1 = $request->mahasiswa1;
        $pengajuanJudul->mahasiswa2 = $request->mahasiswa2;
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
            'mahasiswa1' => 'required',
            'mahasiswa2' => 'required',
            'dospem1' => 'exists:users,id',
            'dospem2' => 'nullable|exists:users,id',
        ]);
        $pengajuanJudul->tahun = $request->tahun;
        $pengajuanJudul->judul = $request->judul;
        $pengajuanJudul->mahasiswa1 = $request->mahasiswa1;
        $pengajuanJudul->mahasiswa2 = $request->mahasiswa2;
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

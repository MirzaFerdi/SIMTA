<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PengajuanJudul;

class BimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bimbingan = Bimbingan::all();
        $dospem = User::where('role_id', 2)->get();
        $userId = auth()->id();
        if (auth()->user()->role_id == 3) {
            $bimbinganUser = Bimbingan::where('pengusul1', $userId)
                ->orWhere('pengusul2', $userId)
                ->get();
        } else {
            $bimbinganUser = collect();
        }
        return view('bimbingan', compact('bimbingan', 'dospem', 'bimbinganUser'));
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
            'dospem_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'topik_bimbingan' => 'required|string|max:255',
        ]);

        $bimbingan = new Bimbingan();
        $bimbingan->dospem_id = $request->dospem_id;

        $pengajuan = PengajuanJudul::where('pengusul1', auth()->id())
            ->orWhere('pengusul2', auth()->id())
            ->first();

        if ($pengajuan) {
            $bimbingan->pengusul1 = $pengajuan->pengusul1;
            $bimbingan->pengusul2 = $pengajuan->pengusul2;
        } else {
            return redirect()->route('bimbingan')->with('error', 'Lengkapi Pengajuan Judul Terlebih Dahulu');
        }
        $bimbingan->tanggal = $request->tanggal;
        $bimbingan->topik_bimbingan = $request->topik_bimbingan;
        $bimbingan->save();

        return redirect()->route('bimbingan')->with('success', 'Bimbingan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bimbingan $bimbingan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bimbingan $bimbingan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bimbingan $bimbingan)
    {
        $request->validate([
            'dospem_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'topik_bimbingan' => 'required|string|max:255',
        ]);

        $bimbingan->dospem_id = $request->dospem_id;

        $pengajuan = PengajuanJudul::where('pengusul1', auth()->id())
            ->orWhere('pengusul2', auth()->id())
            ->first();

        if ($pengajuan) {
            $bimbingan->pengusul1 = $pengajuan->pengusul1;
            $bimbingan->pengusul2 = $pengajuan->pengusul2;
        } else {
            $bimbingan->pengusul1 = null;
            $bimbingan->pengusul2 = null;
        }
        $bimbingan->tanggal = $request->tanggal;
        $bimbingan->topik_bimbingan = $request->topik_bimbingan;
        $bimbingan->save();

        return redirect()->route('bimbingan')->with('success', 'Bimbingan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Bimbingan $bimbingan)
    {
        $request->validate([
            'status' => 'required|string|max:50',
        ]);

        $bimbingan->status = $request->status;
        $bimbingan->save();

        return redirect()->route('bimbingan')->with('success', 'Status bimbingan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bimbingan $bimbingan)
    {
        $bimbingan->delete();
        return redirect()->route('bimbingan')->with('success', 'Bimbingan berhasil dihapus.');
    }
}

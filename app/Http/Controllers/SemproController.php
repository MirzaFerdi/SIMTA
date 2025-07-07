<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Sempro;
use App\Models\User;
use App\Models\PengajuanJudul;
use Illuminate\Http\Request;

class SemproController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sempros = Sempro::all();
        $mahasiswas = User::where('role_id', '3')->get();
        $dospem = User::where('role_id', '2')->get();
        $userId = auth()->id();

        $statusBimbinganTerakhir = null;
        $pengajuanTerakhir = Bimbingan::where(function ($query) use ($userId) {
            $query->where('mahasiswa1', $userId)
                  ->orWhere('mahasiswa2', $userId);
            })
            ->orderByDesc('tanggal')
            ->first();

        if ($pengajuanTerakhir) {
            $statusBimbinganTerakhir = $pengajuanTerakhir->status;
        }
        // $pengajuan = PengajuanJudul::where('status', 'Diterima')
        //     ->where(function ($query) use ($userId) {
        //         $query->where('mahasiswa1', $userId)
        //             ->orWhere('mahasiswa2', $userId);
        //     })->get();
        $pengajuan = PengajuanJudul::where('mahasiswa1', $userId)
            ->orWhere('mahasiswa2', $userId)
            ->get();
        if (auth()->user()->role_id == 3) {
            $semproUser = Sempro::where('mahasiswa1', $userId)
                ->orWhere('mahasiswa2', $userId)
                ->get();
        } else {
            $semproUser = collect();
        }
        return view('sempro', compact('sempros', 'semproUser', 'mahasiswas', 'dospem', 'pengajuan', 'statusBimbinganTerakhir'));
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
            'mahasiswa1' => 'required|exists:users,id',
            'mahasiswa2' => 'nullable|exists:users,id',
            'dospem1' => 'required|exists:users,id',
            'dospem2' => 'required|exists:users,id',
            'pengajuan_id' => 'required|exists:pengajuan_juduls,id',
            'no_ta' => 'required|string|max:255',
            'abstrak' => 'required|string|max:1000',
            'laporan' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'ppt' => 'required|file|max:10240',
        ]);

        $sempro = new Sempro();
        $sempro->mahasiswa1 = $request->mahasiswa1;
        $sempro->mahasiswa2 = $request->mahasiswa2;
        $sempro->dospem1 = $request->dospem1;
        $sempro->dospem2 = $request->dospem2;
        $sempro->pengajuan_id = $request->pengajuan_id;
        $sempro->no_ta = $request->no_ta;
        $sempro->abstrak = $request->abstrak;

        if ($request->hasFile('laporan')) {
            $filename = time() . '_' . $request->file('laporan')->getClientOriginalName();
            $request->file('laporan')->storeAs('public/file/laporan', $filename);
            $sempro->laporan = $filename;
        }

        if ($request->hasFile('ppt')) {
            $filename = time() . '_' . $request->file('ppt')->getClientOriginalName();
            $request->file('ppt')->storeAs('public/file/ppt', $filename);
            $sempro->ppt = $filename;
        }


        // Set default status
        $sempro->status = 'Menunggu';

        $sempro->save();

        return redirect()->route('sempro')->with('success', 'Seminar Proposal berhasil diajukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sempro $sempro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sempro $sempro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sempro $sempro)
    {
        $request->validate([
            'mahasiswa1' => 'required|exists:users,id',
            'mahasiswa2' => 'nullable|exists:users,id',
            'dospem1' => 'required|exists:users,id',
            'dospem2' => 'required|exists:users,id',
            'pengajuan_id' => 'required|exists:pengajuan_juduls,id',
            'no_ta' => 'required|string|max:255',
            'abstrak' => 'required|string|max:1000',
            'laporan' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'ppt' => 'nullable|file|mimes:ppt,pptx|max:10240',
        ]);

        $sempro->mahasiswa1 = $request->mahasiswa1;
        $sempro->mahasiswa2 = $request->mahasiswa2;
        $sempro->dospem1 = $request->dospem1;
        $sempro->dospem2 = $request->dospem2;
        $sempro->pengajuan_id = $request->pengajuan_id;
        $sempro->no_ta = $request->no_ta;
        $sempro->abstrak = $request->abstrak;

        if ($request->hasFile('laporan')) {
            $filename = time() . '_' . $request->file('laporan')->getClientOriginalName();
            $request->file('laporan')->storeAs('public/file/laporan', $filename);
            $sempro->laporan = $filename;
        }

        if ($request->hasFile('ppt')) {
            $filename = time() . '_' . $request->file('ppt')->getClientOriginalName();
            $request->file('ppt')->storeAs('public/file/ppt', $filename);
            $sempro->ppt = $filename;
        }

        if ($request->has('status')) {
            $sempro->status = $request->status;
        }

        $sempro->save();

        return redirect()->route('sempro')->with('success', 'Seminar Proposal berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Sempro $sempro)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak',
        ]);

        $sempro->status = $request->status;
        $sempro->save();

        return redirect()->route('sempro')->with('success', 'Status Seminar Proposal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sempro $sempro)
    {
        //
    }
}

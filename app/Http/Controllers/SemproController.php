<?php

namespace App\Http\Controllers;

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
        $pengajuan = PengajuanJudul::where('status', 'Diterima')
            ->where(function ($query) use ($userId) {
                $query->where('pengusul1', $userId)
                    ->orWhere('pengusul2', $userId);
            })->get();
        if (auth()->user()->role_id == 3) {
            $semproUser = Sempro::where('pengusul1', $userId)
                ->orWhere('pengusul2', $userId)
                ->get();
        } else {
            $semproUser = collect();
        }
        return view('sempro', compact('sempros', 'semproUser', 'mahasiswas', 'dospem', 'pengajuan'));
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
        //
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
        //
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

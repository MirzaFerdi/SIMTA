<?php

namespace App\Http\Controllers;

use App\Models\TugasAkhir;
use Illuminate\Http\Request;

class TugasAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tugasAkhir = TugasAkhir::all();
        return view('ujian.tugasAkhir', compact('tugasAkhir'));
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
    public function show(TugasAkhir $tugasAkhir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TugasAkhir $tugasAkhir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TugasAkhir $tugasAkhir)
    {
        //
    }

    public function updateStatus(Request $request, TugasAkhir $tugasAkhir)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $tugasAkhir->status = $request->status;
        $tugasAkhir->save();

        return redirect()->route('tugas-akhir')->with('success', 'Status Tugas Akhir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TugasAkhir $tugasAkhir)
    {
        //
    }
}

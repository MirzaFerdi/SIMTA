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
    // public function index()
    // {
    //     $bimbingan = Bimbingan::all();
    //     $dospem = User::where('role_id', 2)->get();
    //     $userId = auth()->id();
    //     if (auth()->user()->role_id == 3 || auth()->user()->role_id == 2) {
    //         $bimbinganUser = Bimbingan::where('mahasiswa1', $userId)
    //             ->orWhere('mahasiswa2', $userId)
    //             ->orWhere('dospem1', $userId)
    //             ->orWhere('dospem2', $userId)
    //             ->get();
    //     } else {
    //         $bimbinganUser = collect();
    //     }

    //     $bolehTambah = false;

    //     if (auth()->user()->role_id == 3) {
    //         $terakhir = $bimbinganUser->last();
    //         $bolehTambah = $bimbinganUser->isEmpty() ||
    //             ($terakhir && in_array($terakhir->status, ['Bimbingan Ulang', 'Menunggu']));
    //     }
    //     return view('bimbingan', compact('bimbingan', 'dospem', 'bimbinganUser', 'bolehTambah'));
    // }


    public function index()
    {
        $dospem = User::where('role_id', 2)->get();
        $userId = auth()->id();

        if (auth()->user()->role_id == 3 || auth()->user()->role_id == 2) {
            // Bimbingan sebagai mahasiswa atau dosen pembimbing
            $bimbinganDospem1 = Bimbingan::where('dospem1', $userId)
                ->orWhere(function ($query) use ($userId) {
                    $query->where('mahasiswa1', $userId)
                        ->orWhere('mahasiswa2', $userId);
                })
                ->whereNotNull('dospem1')
                ->get();

            $bimbinganDospem2 = Bimbingan::where('dospem2', $userId)
                ->orWhere(function ($query) use ($userId) {
                    $query->where('mahasiswa1', $userId)
                        ->orWhere('mahasiswa2', $userId);
                })
                ->whereNotNull('dospem2')
                ->get();
        } else {
            $bimbinganDospem1 = collect();
            $bimbinganDospem2 = collect();
        }

        $bolehTambah = false;

        if (auth()->user()->role_id == 3) {
            $terakhir = $bimbinganDospem1->isEmpty() ? null : $bimbinganDospem1->last();
            $bolehTambah = $bimbinganDospem1->isEmpty() ||
                ($terakhir && in_array($terakhir->status, ['Bimbingan Ulang', 'Menunggu']));
        }

        return view('bimbingan', compact('dospem', 'bimbinganDospem1', 'bimbinganDospem2', 'bolehTambah'));
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
        $rules = [
            'dospem_type' => 'required|in:dospem1,dospem2',
            'tanggal' => 'required|date',
            'topik_bimbingan' => 'required|string|max:255',
            'file' => 'sometimes|file|mimes:pdf,doc,docx|max:10240',
        ];

        // Conditional validation
        if ($request->dospem_type === 'dospem1') {
            $rules['dospem1'] = 'required|exists:users,id';
        } else {
            $rules['dospem2'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        $bimbingan = new Bimbingan();

        // Set mahasiswa dari pengajuan judul
        $pengajuan = PengajuanJudul::where('mahasiswa1', auth()->id())
            ->orWhere('mahasiswa2', auth()->id())
            ->first();

        if ($pengajuan) {
            $bimbingan->mahasiswa1 = $pengajuan->mahasiswa1;
            $bimbingan->mahasiswa2 = $pengajuan->mahasiswa2;
        } else {
            return redirect()->route('bimbingan')->with('error', 'Lengkapi Pengajuan Judul Terlebih Dahulu');
        }

        // Set pembimbing berdasarkan jenis yang dipilih
        if ($request->dospem_type === 'dospem1') {
            $bimbingan->dospem1 = $request->dospem1;
        } else {
            $bimbingan->dospem2 = $request->dospem2;
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $filename = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->storeAs('public/file/bimbingan', $filename);
            $bimbingan->file = $filename;
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
            'dospem_type' => 'required|in:dospem1,dospem2',
            'tanggal' => 'required|date',
            'topik_bimbingan' => 'required|string|max:255',
        ]);

        // Update pembimbing
        if ($request->dospem_type === 'dospem1') {
            $bimbingan->dospem1 = $request->dospem1;
            $bimbingan->dospem2 = null; // Clear dospem2 if updating dospem1
        } else {
            $bimbingan->dospem2 = $request->dospem2;
            $bimbingan->dospem1 = null; // Clear dospem1 if updating dospem2
        }

        $pengajuan = PengajuanJudul::where('mahasiswa1', auth()->id())
            ->orWhere('mahasiswa2', auth()->id())
            ->first();

        if ($pengajuan) {
            $bimbingan->mahasiswa1 = $pengajuan->mahasiswa1;
            $bimbingan->mahasiswa2 = $pengajuan->mahasiswa2;
        } else {
            $bimbingan->mahasiswa1 = null;
            $bimbingan->mahasiswa2 = null;
        }
        $bimbingan->tanggal = $request->tanggal;
        $bimbingan->topik_bimbingan = $request->topik_bimbingan;
        $bimbingan->status = 'Menunggu';
        $bimbingan->save();

        return redirect()->route('bimbingan')->with('success', 'Bimbingan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Bimbingan $bimbingan)
    {
        $request->validate([
            'status' => 'required|string|max:50',
            'review' => 'nullable|string|max:500',
        ]);

        $bimbingan->status = $request->status;
        $bimbingan->review = $request->review;
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

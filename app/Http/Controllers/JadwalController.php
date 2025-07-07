<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\PengajuanJudul;
use App\Models\User;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tahunAkademik = $request->query('tahun_akademik');

        $jadwals = Jadwal::when($tahunAkademik, function ($query, $tahunAkademik) {
            return $query->where('tahun_akademik', $tahunAkademik);
        })->get();

        // PENTING: Eager load relasi menggunakan NAMA FUNGSI RELASI dari model PengajuanJudul
        // Yaitu: mahasiswa1Pengajuan, mahasiswa2Pengajuan, dospem1Pengajuan, dospem2Pengajuan
        $pengajuans = PengajuanJudul::where('status', 'Disetujui')
                                    ->with([
                                        'mahasiswa1Pengajuan',
                                        'mahasiswa2Pengajuan',
                                        'dospem1Pengajuan',
                                        'dospem2Pengajuan'
                                    ])
                                    ->get();

        $mahasiswas = User::where('role_id', 3)->get();
        $dosens = User::where('role_id', 2)->get();

        $userId = auth()->id();
        if (auth()->user()->role_id == 3 || auth()->user()->role_id == 2) {
            $jadwalUser = Jadwal::where(function ($query) use ($userId) {
                $query->where('mahasiswa1', $userId)
                    ->orWhere('mahasiswa2', $userId)
                    ->orWhere('dospem1', $userId)
                    ->orWhere('dospem2', $userId)
                    ->orWhere('dosen_penguji1', $userId)
                    ->orWhere('dosen_penguji2', $userId);
            })
                ->when($tahunAkademik, function ($query, $tahunAkademik) {
                    return $query->where('tahun_akademik', $tahunAkademik);
                })
                ->get();
        } else {
            $jadwalUser = collect();
        }
        return view('penjadwalan', compact('jadwals', 'jadwalUser', 'pengajuans', 'mahasiswas', 'dosens'));
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
            'mahasiswa2' => 'required|exists:users,id',
            'dospem1' => 'required|exists:users,id',
            'dospem2' => 'nullable|exists:users,id',
            'dosen_penguji1' => 'required|exists:users,id',
            'dosen_penguji2' => 'nullable|exists:users,id',
            'tanggal' => 'required|date',
            'tahun_akademik' => 'required|string|max:10',
            'jam' => 'required',
            'tempat' => 'required|string|max:255',
            'pengajuan_id' => 'required|exists:pengajuan_juduls,id',
            'status' => 'string|max:50',
        ]);

        $jadwal = new Jadwal();
        $jadwal->mahasiswa1 = $request->mahasiswa1;
        $jadwal->mahasiswa2 = $request->mahasiswa2;
        $jadwal->dospem1 = $request->dospem1;
        $jadwal->dospem2 = $request->dospem2;
        $jadwal->dosen_penguji1 = $request->dosen_penguji1;
        $jadwal->dosen_penguji2 = $request->dosen_penguji2;
        $jadwal->tanggal = $request->tanggal;
        $jadwal->tahun_akademik = $request->tahun_akademik;
        $jadwal->jam = $request->jam;
        $jadwal->tempat = $request->tempat;
        $jadwal->pengajuan_id = $request->pengajuan_id;
        $jadwal->status = $request->status;
        $jadwal->save();


        return redirect()->route('penjadwalan')->with('success', 'Jadwal berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'mahasiswa1' => 'required|exists:users,id',
            'mahasiswa2' => 'required|exists:users,id',
            'dospem1' => 'required|exists:users,id',
            'dospem2' => 'nullable|exists:users,id',
            'dosen_penguji1' => 'required|exists:users,id',
            'dosen_penguji2' => 'nullable|exists:users,id',
            'tanggal' => 'required|date',
            'tahun_akademik' => 'required|string|max:10',
            'jam' => 'required',
            'tempat' => 'required|string|max:255',
            'pengajuan_id' => 'required|exists:pengajuan_juduls,id',
            'status' => 'string|max:50',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('penjadwalan')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('penjadwalan')->with('success', 'Jadwal berhasil dihapus.');
    }
}

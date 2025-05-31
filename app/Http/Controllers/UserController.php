<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminRole = Role::where('nama_role', 'admin')->first();
        $adminRoleId = $adminRole ? $adminRole->id : null;

        $mahasiswas = User::where('role_id', 3)
            ->get()
            ->map(function ($user) {
            try {
                $user->decrypted_password = Crypt::decryptString($user->encrypted_password);
            } catch (\Exception $e) {
                $user->decrypted_password = 'Decryption failed';
            }
            return $user;
            });

        $dosens = User::where('role_id', 2)
            ->get()
            ->map(function ($user) {
            try {
                $user->decrypted_password = Crypt::decryptString($user->encrypted_password);
            } catch (\Exception $e) {
                $user->decrypted_password = 'Decryption failed';
            }
            return $user;
            });

        $roles = Role::all();
        return view('user', compact('mahasiswas', 'dosens', 'roles'));
    }

    public function profile()
    {
        $user = Auth::user();

        try {
            $user->decrypted_password = Crypt::decryptString($user->encrypted_password);
        } catch (\Exception $e) {
            $user->decrypted_password = 'Decryption failed';
        }

        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,heic|max:2048',
        ],
        [
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar tidak valid',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);


        $user->nama = $request->nama;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->encrypted_password = Crypt::encryptString($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::exists('public/foto-profile/' . $user->foto)) {
                Storage::delete('public/foto-profile/' . $user->foto);
            }

            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('public/foto-profile', $filename);
            $user->foto = $filename;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email',
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
        ],
        [
            'nama.required' => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Email tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;

        if ($request->username !== $user->username) {
            $user->username = $request->username;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->encrypted_password = Crypt::encryptString($request->password);
        }

        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('user')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user')->with('success', 'User berhasil dihapus.');
    }
}

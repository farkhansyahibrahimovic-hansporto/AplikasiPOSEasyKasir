<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // Menampilkan daftar petugas
    public function index()
    {
        // Cek role admin
        if (Auth::user()->role !== 'administrator') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Hanya administrator yang bisa mengakses.');
        }

        $petugas = User::where('role', 'petugas')->get();
        return view('petugas.index', compact('petugas'));
    }

    // Menampilkan form tambah petugas
    public function create()
    {
        // Cek role admin
        if (Auth::user()->role !== 'administrator') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Hanya administrator yang bisa menambah petugas.');
        }

        return view('petugas.create');
    }

    // Menyimpan petugas baru
    public function store(Request $request)
    {
        // Cek role admin
        if (Auth::user()->role !== 'administrator') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return redirect()->route('petugas.index')->with('success', 'Petugas baru berhasil ditambahkan!');
    }

    // Menampilkan detail petugas
    public function show($id)
    {
        // Cek role admin
        if (Auth::user()->role !== 'administrator') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $petugas = User::where('id', $id)->where('role', 'petugas')->firstOrFail();
        return view('petugas.show', compact('petugas'));
    }

    // Menampilkan form edit petugas
    public function edit($id)
    {
        // Cek role admin
        if (Auth::user()->role !== 'administrator') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $petugas = User::where('id', $id)->where('role', 'petugas')->firstOrFail();
        return view('petugas.edit', compact('petugas'));
    }

    // Update data petugas
    public function update(Request $request, $id)
    {
        // Cek role admin
        if (Auth::user()->role !== 'administrator') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $petugas = User::where('id', $id)->where('role', 'petugas')->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$petugas->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);

        return redirect()->route('petugas.index')->with('success', 'Data petugas berhasil diperbarui!');
    }

    // Menghapus petugas
    public function destroy($id)
    {
        // Cek role admin
        if (Auth::user()->role !== 'administrator') {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $petugas = User::where('id', $id)->where('role', 'petugas')->firstOrFail();
        $petugas->delete();

        return redirect()->route('petugas.index')->with('success', 'Petugas berhasil dihapus!');
    }
}
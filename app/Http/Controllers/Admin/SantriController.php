<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\KelasSantri;
use App\Models\User; // Untuk Wali Santri

class SantriController extends Controller
{
    // READ (Tampilkan semua data)
    public function index()
    {
        $santris = Santri::with(['kelas', 'waliSantri'])->latest()->get();
        return view('admin.master.santri.index', compact('santris'));
    }

    // CREATE (Tampilkan form)
    public function create()
    {
        $kelas = KelasSantri::all();
        $walis = User::where('role', 'wali_santri')->get();
        return view('admin.master.santri.create', compact('kelas', 'walis'));
    }

    // CREATE (Simpan data)
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|string|unique:santris,nisn',
            'kelas_id' => 'required|exists:kelas_santris,id',
            'wali_santri_id' => 'required|exists:users,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Santri::create($request->all());

        return redirect()->route('admin.santri.index')->with('success', 'Data Santri berhasil ditambahkan.');
    }

    // READ (Tampilkan detail data)
    public function show(Santri $santri)
    {
        // Memuat relasi untuk memastikan data lengkap tersedia di view
        $santri->load(['kelas', 'waliSantri']); 
        
        return view('admin.master.santri.show', compact('santri'));
    }
    
    // UPDATE (Tampilkan form edit)
    public function edit(Santri $santri)
    {
        $kelas = KelasSantri::all();
        $walis = User::where('role', 'wali_santri')->get();
        return view('admin.master.santri.edit', compact('santri', 'kelas', 'walis'));
    }

    // UPDATE (Simpan perubahan)
    public function update(Request $request, Santri $santri)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            // Pastikan NISN unik kecuali untuk diri sendiri
            'nisn' => 'required|string|unique:santris,nisn,' . $santri->id, 
            'kelas_id' => 'required|exists:kelas_santris,id',
            'wali_santri_id' => 'required|exists:users,id',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $santri->update($request->all());

        return redirect()->route('admin.santri.index')->with('success', 'Data Santri berhasil diperbarui.');
    }

    // DELETE
    public function destroy(Santri $santri)
    {
        $santri->delete();
        return redirect()->route('admin.santri.index')->with('success', 'Data Santri berhasil dihapus.');
    }
}
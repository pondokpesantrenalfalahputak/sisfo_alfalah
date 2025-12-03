<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasSantri;
use Illuminate\Http\Request;

class KelasSantriController extends Controller
{
    /**
     * Menampilkan daftar semua kelas.
     */
    public function index()
    {
        $kelas = KelasSantri::all();
        // Variabel $kelas (jamak) diteruskan
        return view('admin.master.kelas.index', compact('kelas'));
    }

    /**
     * Menampilkan formulir untuk membuat kelas baru.
     */
    public function create()
    {
        return view('admin.master.kelas.create');
    }

    /**
     * Menyimpan data kelas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:kelas_santris',
            'tingkat' => 'required|string|max:10',
        ]);

        KelasSantri::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail spesifik dari satu kelas.
     * Menggunakan Route Model Binding ($kela).
     */
    public function show(KelasSantri $kela)
    {
        return view('admin.master.kelas.show', compact('kela'));
    }

    /**
     * Menampilkan formulir untuk mengedit data kelas.
     * Menggunakan Route Model Binding ($kela).
     */
    public function edit(KelasSantri $kela)
    {
        return view('admin.master.kelas.edit', compact('kela'));
    }

    /**
     * Memperbarui data kelas di database.
     */
    public function update(Request $request, KelasSantri $kela)
    {
        $request->validate([
            // Memastikan nama_kelas unik, kecuali untuk ID kelas yang sedang diedit
            'nama_kelas' => 'required|string|max:255|unique:kelas_santris,nama_kelas,' . $kela->id,
            'tingkat' => 'required|string|max:10',
        ]);

        $kela->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil diperbarui.');
    }

    /**
     * Menghapus data kelas dari database.
     * Menggunakan Route Model Binding ($kela).
     */
    public function destroy(KelasSantri $kela)
    {
        $kela->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil dihapus.');
    }
}
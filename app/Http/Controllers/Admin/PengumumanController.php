<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class PengumumanController extends Controller
{
    /**
     * Menampilkan daftar semua pengumuman.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Menampilkan yang terbaru di atas
        $pengumumans = Pengumuman::latest()->paginate(10); 
        return view('admin.pengumuman.index', compact('pengumumans'));
    }

    /**
     * Menampilkan formulir untuk membuat pengumuman baru.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }

    /**
     * Menyimpan pengumuman yang baru dibuat di database.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            // Kita wajibkan tanggal publikasi diisi Admin, meskipun statusnya otomatis published
            'tanggal_publikasi' => 'required|date', 
            'kategori' => 'nullable|string|max:100', // Tambahkan validasi kategori
            'status' => 'required|in:draft,published', // Tambahkan validasi status
        ]);
        
        // --- LOGIKA UTAMA: MENYIMPAN STATUS & KATEGORI ---
        
        // Persiapkan data yang akan disimpan
        $dataToCreate = [
            'judul' => $validatedData['judul'], 
            'isi' => $validatedData['isi'], 
            'tanggal_publikasi' => $validatedData['tanggal_publikasi'],
            'kategori' => $validatedData['kategori'] ?? null,
            'status' => $validatedData['status'], // Ambil status dari form
        ];

        // Jika Anda ingin membuat 'status' selalu 'published' secara default (mengabaikan input form):
        // $dataToCreate['status'] = 'published'; 

        Pengumuman::create($dataToCreate); 

        // --- AKHIR LOGIKA UTAMA ---

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pengumuman spesifik.
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\View\View
     */
    public function show(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Menampilkan formulir edit untuk pengumuman spesifik.
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\View\View
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Memperbarui pengumuman spesifik di database.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'kategori' => 'nullable|string|max:100', // Tambahkan validasi kategori
            'status' => 'required|in:draft,published', // Tambahkan validasi status
        ]);

        // --- LOGIKA UTAMA: MEMPERBARUI STATUS & KATEGORI ---
        
        // Persiapkan data yang akan diupdate
        $dataToUpdate = [
            'judul' => $validatedData['judul'], 
            'isi' => $validatedData['isi'], 
            'tanggal_publikasi' => $validatedData['tanggal_publikasi'],
            'kategori' => $validatedData['kategori'] ?? null,
            'status' => $validatedData['status'], // Ambil status dari form
        ];
        
        $pengumuman->update($dataToUpdate);

        // --- AKHIR LOGIKA UTAMA ---
        
        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Menghapus pengumuman spesifik dari database.
     * @param  \App\Models\Pengumuman  $pengumuman
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Menampilkan daftar guru dengan fitur pencarian dan paginasi.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Guru::query();
        
        // 1. Ambil input pencarian dari URL (query string: ?search=...)
        $search = $request->get('search');

        // 2. Terapkan Logika Pencarian jika ada input 'search'
        if ($search) {
            // Mencari di kolom 'nama_lengkap' ATAU 'nuptk' (case-insensitive)
            $query->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nuptk', 'like', '%' . $search . '%');
        }

        // 3. Ambil data guru yang sudah difilter/semua data dan terapkan paginasi
        // Menggunakan 10 item per halaman
        $gurus = $query->paginate(10); 

        // 4. Kirim data guru dan variabel $search (untuk mempertahankan nilai di input field) ke view
        return view('admin.master.guru.index', compact('gurus', 'search'));
    }

    /**
     * Menampilkan form untuk membuat data guru baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.master.guru.create');
    }

    /**
     * Menyimpan data guru baru ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nuptk' => 'required|string|max:20|unique:gurus',
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        Guru::create($request->all());

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data guru tertentu.
     *
     * @param \App\Models\Guru $guru
     * @return \Illuminate\View\View
     */
    public function show(Guru $guru)
    {
        return view('admin.master.guru.show', compact('guru'));
    }

    /**
     * Menampilkan form untuk mengedit data guru tertentu.
     *
     * @param \App\Models\Guru $guru
     * @return \Illuminate\View\View
     */
    public function edit(Guru $guru)
    {
        return view('admin.master.guru.edit', compact('guru'));
    }

    /**
     * Memperbarui data guru tertentu di database.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Guru $guru
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            // Pastikan NUPTK unik, kecuali untuk data guru yang sedang diedit
            'nuptk' => 'required|string|max:20|unique:gurus,nuptk,' . $guru->id,
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        $guru->update($request->all());

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    /**
     * Menghapus data guru tertentu dari database.
     *
     * @param \App\Models\Guru $guru
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil dihapus.');
    }
}
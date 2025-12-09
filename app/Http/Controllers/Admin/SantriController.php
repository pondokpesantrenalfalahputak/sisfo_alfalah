<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\KelasSantri;
use App\Models\User; // Untuk Wali Santri

class SantriController extends Controller
{
    // READ (Tampilkan semua data) DENGAN FITUR PENCARIAN, PAGINASI, DAN FILTER WALI
    public function index(Request $request)
    {
        // 1. Ambil input dari request
        $search = $request->input('search');
        $waliSantriId = $request->input('wali_santri_id');

        // 2. Mulai query dasar untuk Model Santri
        $query = Santri::query();

        // 3. Terapkan filter PENCARIAN (NISN dan Nama Santri)
        if ($search) {
            $query->where(function($q) use ($search) {
                // Cari berdasarkan NISN
                $q->where('nisn', 'LIKE', "%{$search}%")
                  // ATAU Cari berdasarkan Nama Lengkap Santri
                  ->orWhere('nama_lengkap', 'LIKE', "%{$search}%");
            });
        }
        
        // 4. Terapkan filter BERDASARKAN WALI SANTRI
        if ($waliSantriId) {
            // Memfilter santri yang memiliki wali_santri_id sesuai input
            $query->where('wali_santri_id', $waliSantriId);
        }

        // 5. Ambil data, tambahkan relasi dan paginasi
        $santris = $query->with(['kelas', 'waliSantri'])
                        ->orderBy('nama_lengkap', 'asc')
                        ->paginate(10) // Paginasi 10 data per halaman
                        // Mempertahankan filter saat navigasi paginasi
                        ->withQueryString(); 

        // Tambahkan daftar wali untuk digunakan di dropdown filter pada view
        $walis = User::where('role', 'wali_santri')->get(); 

        // Kirim data santri, daftar wali, dan nilai filter yang sedang aktif
        return view('admin.master.santri.index', compact('santris', 'walis', 'waliSantriId'));
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
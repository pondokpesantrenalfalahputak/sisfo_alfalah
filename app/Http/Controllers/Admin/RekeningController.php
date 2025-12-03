<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function index()
    {
        $rekenings = Rekening::all();
        return view('admin.rekening.index', compact('rekenings'));
    }

    public function create()
    {
        return view('admin.rekening.create');
    }

    /**
     * Menyimpan data Rekening Bank baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            // ✅ PERBAIKAN: Menggunakan nama tabel yang benar: rekening_banks
            'nomor_rekening' => 'required|string|max:50|unique:rekening_banks',
            'atas_nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Rekening::create($request->all());

        return redirect()->route('admin.rekening.index')->with('success', 'Data Rekening berhasil ditambahkan.');
    }

    public function show(Rekening $rekening)
    {
        return view('admin.rekening.show', compact('rekening'));
    }

    public function edit(Rekening $rekening)
    {
        return view('admin.rekening.edit', compact('rekening'));
    }

    /**
     * Memperbarui data Rekening Bank yang sudah ada.
     */
    public function update(Request $request, Rekening $rekening)
    {
        // Pastikan Anda menangani validasi unik dengan benar saat mengedit
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            // ✅ PERBAIKAN: Menggunakan nama tabel yang benar: rekening_banks
            // Mengabaikan ID rekening yang sedang diedit (.$rekening->id)
            'nomor_rekening' => 'required|string|max:50|unique:rekening_banks,nomor_rekening,' . $rekening->id,
            'atas_nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $rekening->update($request->all());

        return redirect()->route('admin.rekening.index')->with('success', 'Data Rekening berhasil diperbarui.');
    }

    public function destroy(Rekening $rekening)
    {
        // Perhatian: Pastikan tidak ada data Pembayaran yang merujuk ke rekening ini
        // sebelum dihapus, atau Anda akan mendapatkan error Foreign Key Constraint.
        // Jika ada, tambahkan penanganan try-catch atau batasan pada tombol delete di view.
        
        $rekening->delete();

        return redirect()->route('admin.rekening.index')->with('success', 'Data Rekening berhasil dihapus.');
    }
}
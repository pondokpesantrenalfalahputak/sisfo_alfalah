<?php

namespace App\Http\Controllers\WaliSantri;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Mengganti 'aktif' menjadi 'published'
        $pengumumen = Pengumuman::where('status', 'published')
            ->orderBy('tanggal_publikasi', 'desc')
            ->paginate(10);

        return view('wali.pengumuman.index', compact('pengumumen'));
    }

    public function show(Pengumuman $pengumuman)
    {
        // Pastikan pengumuman aktif/published
        if ($pengumuman->status !== 'published') { // PERBAIKAN: Mengganti 'aktif' menjadi 'published'
            return redirect()->route('wali.pengumuman.index')->with('error', 'Pengumuman tidak tersedia.');
        }

        return view('wali.pengumuman.show', compact('pengumuman'));
    }
}
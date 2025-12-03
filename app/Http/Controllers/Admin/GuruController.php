<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::all();
        return view('admin.master.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.master.guru.create');
    }

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

    public function show(Guru $guru)
    {
        return view('admin.master.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('admin.master.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nuptk' => 'required|string|max:20|unique:gurus,nuptk,' . $guru->id,
            'jabatan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        $guru->update($request->all());

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil dihapus.');
    }
}

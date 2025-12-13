<?php

namespace App\Http\Controllers;

use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupirController extends Controller
{
    public function index()
    {
        $supirs = Supir::all();
        return view('supirs.index', compact('supirs'));
    }

    public function create()
    {
        return view('supirs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:supirs',
            'no_hp' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tarif_per_hari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,bertugas',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('supirs', 'public');
        }
        $data['foto'] = $fotoPath;

        Supir::create($data);
        return redirect()->route('supirs.index')->with('success', 'Supir berhasil ditambahkan.');
    }

    public function show(Supir $supir)
    {
        return view('supirs.show', compact('supir'));
    }

    public function edit(Supir $supir)
    {
        return view('supirs.edit', compact('supir'));
    }

    public function update(Request $request, Supir $supir)
    {
        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'nik' => 'sometimes|string|max:255|unique:supirs,nik,' . $supir->id,
            'no_hp' => 'sometimes|string|max:255',
            'alamat' => 'sometimes|string',
            'tarif_per_hari' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:tersedia,bertugas',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        $fotoPath = $supir->foto; // Keep old path if no new file
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($supir->foto && Storage::disk('public')->exists($supir->foto)) {
                Storage::disk('public')->delete($supir->foto);
            }
            $fotoPath = $request->file('foto')->store('supirs', 'public');
        }
        $data['foto'] = $fotoPath;

        $supir->update($data);
        return redirect()->route('supirs.index')->with('success', 'Supir berhasil diperbarui.');
    }

    public function destroy(Supir $supir)
    {
        // Hapus foto jika ada
        if ($supir->foto && Storage::disk('public')->exists($supir->foto)) {
            Storage::disk('public')->delete($supir->foto);
        }

        $supir->delete();
        return redirect()->route('supirs.index')->with('success', 'Supir berhasil dihapus.');
    }
}
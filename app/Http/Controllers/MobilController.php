<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Merek;
use App\Models\JenisMobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::with('merek', 'jenisMobil')->get();
        return view('mobils.index', compact('mobils'));
    }

    public function create()
    {
        $mereks = Merek::all();
        $jenisMobils = JenisMobil::all();
        return view('mobils.create', compact('mereks', 'jenisMobils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'merek_id' => 'required|exists:mereks,id',
            'jenis_mobil_id' => 'required|exists:jenis_mobils,id',
            'nama_mobil' => 'required|string|max:255',
            'no_polisi' => 'required|string|max:255|unique:mobils',
            'harga_per_hari' => 'required|numeric|min:0',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required|in:tersedia,disewa',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('mobils', 'public');
        }
        $data['gambar'] = $gambarPath;

        Mobil::create($data);
        return redirect()->route('mobils.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function show(Mobil $mobil)
    {
        return view('mobils.show', compact('mobil'));
    }

    public function edit(Mobil $mobil)
    {
        $mereks = Merek::all();
        $jenisMobils = JenisMobil::all();
        return view('mobils.edit', compact('mobil', 'mereks', 'jenisMobils'));
    }

    public function update(Request $request, Mobil $mobil)
    {
        $request->validate([
            'merek_id' => 'sometimes|exists:mereks,id',
            'jenis_mobil_id' => 'sometimes|exists:jenis_mobils,id',
            'nama_mobil' => 'sometimes|string|max:255',
            'no_polisi' => 'sometimes|string|max:255|unique:mobils,no_polisi,' . $mobil->id,
            'harga_per_hari' => 'sometimes|numeric|min:0',
            'tahun' => 'sometimes|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'sometimes|in:tersedia,disewa',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        $gambarPath = $mobil->gambar; // Keep old path if no new file
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($mobil->gambar && Storage::disk('public')->exists($mobil->gambar)) {
                Storage::disk('public')->delete($mobil->gambar);
            }
            $gambarPath = $request->file('gambar')->store('mobils', 'public');
        }
        $data['gambar'] = $gambarPath;

        $mobil->update($data);
        return redirect()->route('mobils.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    public function destroy(Mobil $mobil)
    {
        // Hapus gambar jika ada
        if ($mobil->gambar && Storage::disk('public')->exists($mobil->gambar)) {
            Storage::disk('public')->delete($mobil->gambar);
        }

        $mobil->delete();
        return redirect()->route('mobils.index')->with('success', 'Mobil berhasil dihapus.');
    }
}

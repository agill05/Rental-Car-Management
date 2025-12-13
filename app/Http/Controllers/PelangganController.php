<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('pelanggans.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:pelanggans',
            'no_hp' => 'required|string|max:255',
            'alamat' => 'required|string',
        ]);

        Pelanggan::create($request->all());
        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show(Pelanggan $pelanggan)
    {
        return view('pelanggans.show', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggans.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama_pelanggan' => 'sometimes|string|max:255',
            'nik' => 'sometimes|string|max:255|unique:pelanggans,nik,' . $pelanggan->id,
            'no_hp' => 'sometimes|string|max:255',
            'alamat' => 'sometimes|string',
        ]);

        $pelanggan->update($request->all());
        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return response()->json(['message' => 'Pelanggan deleted successfully']);
    }
}

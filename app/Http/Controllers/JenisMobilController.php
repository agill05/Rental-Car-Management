<?php

namespace App\Http\Controllers;

use App\Models\JenisMobil;
use Illuminate\Http\Request;

class JenisMobilController extends Controller
{
    public function index()
    {
        $jenisMobils = JenisMobil::all();
        return view('jenis_mobils.index', compact('jenisMobils'));
    }

    public function create()
    {
        return view('jenis_mobils.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        JenisMobil::create($request->all());
        return redirect()->route('jenis_mobils.index')->with('success', 'Jenis Mobil berhasil ditambahkan.');
    }

    public function show(JenisMobil $jenisMobil)
    {
        return view('jenis_mobils.show', compact('jenisMobil'));
    }

    public function edit(JenisMobil $jenisMobil)
    {
        return view('jenis_mobils.edit', compact('jenisMobil'));
    }

    public function update(Request $request, JenisMobil $jenisMobil)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        $jenisMobil->update($request->all());
        return redirect()->route('jenis_mobils.index')->with('success', 'Jenis Mobil berhasil diperbarui.');
    }

    public function destroy(JenisMobil $jenisMobil)
    {
        $jenisMobil->delete();
        return response()->json(['message' => 'Jenis Mobil deleted successfully']);
    }
}

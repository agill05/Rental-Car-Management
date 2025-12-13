<?php

namespace App\Http\Controllers;

use App\Models\Merek;
use Illuminate\Http\Request;

class MerekController extends Controller
{
    public function index()
    {
        $mereks = Merek::all();
        return view('mereks.index', compact('mereks'));
    }

    public function create()
    {
        return view('mereks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_merek' => 'required|string|max:255',
        ]);

        Merek::create($request->all());
        return redirect()->route('mereks.index')->with('success', 'Merek berhasil ditambahkan.');
    }

    public function show(Merek $merek)
    {
        return view('mereks.show', compact('merek'));
    }

    public function edit(Merek $merek)
    {
        return view('mereks.edit', compact('merek'));
    }

    public function update(Request $request, Merek $merek)
    {
        $request->validate([
            'nama_merek' => 'required|string|max:255',
        ]);

        $merek->update($request->all());
        return redirect()->route('mereks.index')->with('success', 'Merek berhasil diperbarui.');
    }

    public function destroy(Merek $merek)
    {
        $merek->delete();
        return redirect()->route('mereks.index')->with('success', 'Merek berhasil dihapus.');
    }
}

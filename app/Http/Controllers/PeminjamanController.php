<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Mobil;
use App\Models\Pelanggan;
use App\Models\Supir;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Admin melihat semua transaksi
        $peminjamans = Peminjaman::with('mobil', 'pelanggan', 'supir')->latest()->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $mobils = Mobil::where('status', 'tersedia')->get();
        $pelanggans = Pelanggan::all();
        $supirs = Supir::where('status', 'tersedia')->get();
        return view('peminjaman.create', compact('mobils', 'pelanggans', 'supirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tanggal_pinjam' => 'required|date',
            'lama_sewa' => 'required|integer|min:1',
        ]);

        // Logika hitung manual untuk Admin
        $mobil = Mobil::find($request->mobil_id);
        $harga_supir = 0;

        if ($request->supir_id) {
            $supir = Supir::find($request->supir_id);
            $harga_supir = $supir->tarif_per_hari;
            $supir->update(['status' => 'bertugas']);
        }

        $total = ($mobil->harga_per_hari + $harga_supir) * $request->lama_sewa;
        $tgl_kembali = date('Y-m-d', strtotime($request->tanggal_pinjam . ' + ' . $request->lama_sewa . ' days'));

        Peminjaman::create([
            'mobil_id' => $request->mobil_id,
            'pelanggan_id' => $request->pelanggan_id,
            'supir_id' => $request->supir_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $tgl_kembali,
            'lama_sewa' => $request->lama_sewa,
            'harga_total' => $total,
            'status' => 'dipinjam' // Default status
        ]);

        $mobil->update(['status' => 'disewa']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dibuat oleh Admin.');
    }

    public function show(Peminjaman $peminjaman)
    {
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $mobils = Mobil::all(); // Tampilkan semua untuk edit (hati-hati logika status)
        $pelanggans = Pelanggan::all();
        $supirs = Supir::all();
        return view('peminjaman.edit', compact('peminjaman', 'mobils', 'pelanggans', 'supirs'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        // Fitur update data transaksi (jika admin salah input)
        $peminjaman->update($request->all());
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Reset status mobil jika dihapus paksa
        if($peminjaman->mobil) {
            $peminjaman->mobil->update(['status' => 'tersedia']);
        }
        if($peminjaman->supir) {
            $peminjaman->supir->update(['status' => 'tersedia']);
        }
        
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data dihapus.');
    }
}
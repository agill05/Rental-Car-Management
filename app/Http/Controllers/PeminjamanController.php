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

    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu_persetujuan') {
            return back()->with('error', 'Peminjaman ini tidak menunggu persetujuan.');
        }

        $peminjaman->update(['status' => 'dipinjam']);

        if ($peminjaman->mobil) {
            $peminjaman->mobil->update(['status' => 'disewa']);
        }

        if ($peminjaman->supir) {
            $peminjaman->supir->update(['status' => 'bertugas']);
        }

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function approveReturn(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu_persetujuan_pengembalian') {
            return back()->with('error', 'Pengembalian ini tidak menunggu persetujuan.');
        }

        // Hitung biaya akhir (seperti di PengembalianController)
        $denda = $peminjaman->calculateFine();
        $biaya_kerusakan = 0; // Default 0, bisa diubah admin nanti jika perlu
        $total_akhir = $peminjaman->harga_total + $denda + $biaya_kerusakan;

        // 1. Simpan data pengembalian
        \App\Models\Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali_aktual' => now(),
            'denda' => $denda,
            'total_bayar_akhir' => $total_akhir,
            'catatan_kondisi' => 'Pengembalian disetujui admin - kondisi baik',
        ]);

        // 2. Update status peminjaman menjadi selesai
        $peminjaman->update(['status' => 'dikembalikan']);

        // 3. Update mobil kembali tersedia
        if ($peminjaman->mobil) {
            $peminjaman->mobil->update(['status' => 'tersedia']);
        }

        // 4. Update supir kembali tersedia (jika ada)
        if ($peminjaman->supir) {
            $peminjaman->supir->update(['status' => 'tersedia']);
        }

        return back()->with('success', 'Pengembalian disetujui dan diproses. Mobil kini tersedia kembali.');
    }
}
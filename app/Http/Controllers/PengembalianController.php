<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman.pelanggan', 'peminjaman.mobil')
            ->latest()
            ->get();

        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::whereIn('status', ['dipinjam', 'menunggu_persetujuan', 'menunggu_pengembalian'])
            ->with('pelanggan', 'mobil')
            ->get();

        return view('pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tanggal_kembali_aktual' => 'required|date',
            'biaya_kerusakan' => 'nullable|numeric|min:0',
            'status_pembayaran' => 'required|in:belum_bayar,sudah_bayar',
            'catatan_kondisi' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        if ($peminjaman->status === 'dikembalikan' || $peminjaman->pengembalian) {
            return back()->with('error', 'Transaksi ini sudah selesai sebelumnya.');
        }

        if ($peminjaman->status === 'menunggu_pengembalian') {
            $peminjaman->update(['status' => 'dipinjam']);
        }

        $denda = $peminjaman->calculateFine();
        $biaya_kerusakan = $request->biaya_kerusakan ?? 0;
        $total_akhir = $peminjaman->harga_total + $denda + $biaya_kerusakan;

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual,
            'denda' => $denda,
            'total_bayar_akhir' => $total_akhir,
            'catatan_kondisi' => $request->catatan_kondisi,
        ]);

        $peminjaman->update(['status' => 'dikembalikan']);

        if ($peminjaman->mobil) {
            $peminjaman->mobil->update(['status' => 'tersedia']);
        }

        if ($peminjaman->supir) {
            $peminjaman->supir->update(['status' => 'tersedia']);
        }

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diproses. Mobil kini tersedia kembali.');
    }

    public function show(Pengembalian $pengembalian)
    {
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        return view('pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $request->validate([
            'tanggal_kembali_aktual' => 'required|date',
            'biaya_kerusakan' => 'nullable|numeric|min:0',
            'status_pembayaran' => 'required|in:belum_bayar,sudah_bayar',
            'total_bayar_akhir' => 'required|numeric|min:0', 
            'catatan_kondisi' => 'nullable|string',
        ]);

        $peminjaman = $pengembalian->peminjaman;
        $denda = $peminjaman->calculateFine();
        $biaya_kerusakan = $request->biaya_kerusakan ?? 0;
        $total_akhir = $peminjaman->harga_total + $denda + $biaya_kerusakan;

        $pengembalian->update([
            'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual,
            'denda' => $denda,
            'biaya_kerusakan' => $biaya_kerusakan,
            'status_pembayaran' => $request->status_pembayaran,
            'total_bayar_akhir' => $total_akhir,
            'catatan_kondisi' => $request->catatan_kondisi
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $peminjaman = $pengembalian->peminjaman;

        if ($peminjaman) {
            $peminjaman->update(['status' => 'dipinjam']);

            if ($peminjaman->mobil) {
                $peminjaman->mobil->update(['status' => 'disewa']);
            }

            if ($peminjaman->supir) {
                $peminjaman->supir->update(['status' => 'bertugas']);
            }
        }

        $pengembalian->delete();
        
        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian dihapus. Status transaksi kembali menjadi dipinjam.');
    }
}
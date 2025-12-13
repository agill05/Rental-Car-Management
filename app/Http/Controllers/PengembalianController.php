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
        // Menampilkan semua riwayat pengembalian (terbaru di atas)
        $pengembalians = Pengembalian::with('peminjaman.pelanggan', 'peminjaman.mobil')
            ->latest()
            ->get();
            
        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        // Admin bisa memproses peminjaman yang statusnya 'dipinjam' 
        // ATAU 'menunggu_persetujuan' (yang diajukan user)
        $peminjamans = Peminjaman::whereIn('status', ['dipinjam', 'menunggu_persetujuan'])
            ->with('pelanggan', 'mobil')
            ->get();
            
        // Jika ada parameter 'peminjaman_id' dari URL (misal dari tombol di dashboard/detail), kirim ke view
        // View create akan otomatis memilih opsi tersebut
        
        return view('pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tanggal_kembali_aktual' => 'required|date',
            'denda' => 'nullable|numeric|min:0',
            'catatan_kondisi' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);
        
        // Cek validasi: jangan sampai memproses yang sudah dikembalikan
        if ($peminjaman->status === 'dikembalikan' || $peminjaman->pengembalian) {
            return back()->with('error', 'Transaksi ini sudah selesai sebelumnya.');
        }

        // Jika status 'menunggu_pengembalian', ubah ke 'dipinjam' sebelum proses pengembalian
        if ($peminjaman->status === 'menunggu_pengembalian') {
            $peminjaman->update(['status' => 'dipinjam']);
        }

        // Hitung Total Bayar Akhir (Server Side Calculation)
        // Total = Harga Awal (Sewa x Hari) + Denda Keterlambatan
        $denda = $request->denda ?? 0;
        $total_akhir = $peminjaman->harga_total + $denda;

        // 1. Simpan Data Pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual,
            'denda' => $denda,
            'total_bayar_akhir' => $total_akhir,
            'catatan_kondisi' => $request->catatan_kondisi,
        ]);

        // 2. Update Status Peminjaman -> Selesai
        $peminjaman->update(['status' => 'dikembalikan']);

        // 3. Update Mobil -> Tersedia Kembali
        if ($peminjaman->mobil) {
            $peminjaman->mobil->update(['status' => 'tersedia']);
        }

        // 4. Update Supir (jika ada) -> Tersedia Kembali
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
            'denda' => 'nullable|numeric|min:0',
            'total_bayar_akhir' => 'required|numeric|min:0', // Admin bisa override total manual jika perlu
            'catatan_kondisi' => 'nullable|string',
        ]);

        $pengembalian->update([
            'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual,
            'denda' => $request->denda ?? 0,
            'total_bayar_akhir' => $request->total_bayar_akhir,
            'catatan_kondisi' => $request->catatan_kondisi
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        // Fitur Rollback: Jika data pengembalian dihapus (karena salah input),
        // kembalikan status mobil & peminjaman ke kondisi "sedang dipinjam".
        
        $peminjaman = $pengembalian->peminjaman;
        
        if ($peminjaman) {
            // Kembalikan status peminjaman
            $peminjaman->update(['status' => 'dipinjam']);
            
            // Kembalikan status mobil jadi disewa
            if ($peminjaman->mobil) {
                $peminjaman->mobil->update(['status' => 'disewa']);
            }
            
            // Kembalikan status supir jadi bertugas (jika ada)
            if ($peminjaman->supir) {
                $peminjaman->supir->update(['status' => 'bertugas']);
            }
        }

        $pengembalian->delete();
        
        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian dihapus. Status transaksi kembali menjadi dipinjam.');
    }
}
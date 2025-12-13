<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Supir;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRentalController extends Controller
{
    public function index()
    {
        $mobils = Mobil::with('merek', 'jenisMobil')
            ->where('status', 'tersedia')
            ->latest()
            ->get();
        return view('home', compact('mobils'));
    }

    public function myRentals()
    {
        $user = Auth::user();
        if (!$user->pelanggan) {
            return redirect()->route('home')->with('error', 'Data pelanggan tidak valid.');
        }

        $rentals = Peminjaman::with(['mobil', 'supir'])
            ->where('pelanggan_id', $user->pelanggan->id)
            ->latest()
            ->get();

        return view('user.penyewaan_saya', compact('rentals'));
    }

    public function createRental(Mobil $mobil)
    {
        if ($mobil->status !== 'tersedia') {
            return back()->with('error', 'Mobil ini tidak tersedia.');
        }

        $supirs = Supir::where('status', 'tersedia')->get();
        return view('user.buat_penyewaan', compact('mobil', 'supirs'));
    }

    public function storeRental(Request $request)
    {
        $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'lama_sewa' => 'required|integer|min:1',
        ]);

        $mobil = Mobil::find($request->mobil_id);

        // Check for overlapping rentals
        $overlapping = Peminjaman::where('mobil_id', $request->mobil_id)
            ->whereIn('status', ['dipinjam', 'menunggu_persetujuan', 'terlambat'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_pinjam', [$request->tanggal_pinjam, date('Y-m-d', strtotime($request->tanggal_pinjam . ' + ' . $request->lama_sewa . ' days'))])
                    ->orWhereBetween('tanggal_kembali_rencana', [$request->tanggal_pinjam, date('Y-m-d', strtotime($request->tanggal_pinjam . ' + ' . $request->lama_sewa . ' days'))]);
            })
            ->exists();

        if ($overlapping) {
            return back()->with('error', 'Mobil sudah dipesan pada tanggal tersebut.');
        }

        $biaya_mobil = $mobil->harga_per_hari;
        $biaya_supir = 0;

        if ($request->supir_id) {
            $supir = Supir::find($request->supir_id);
            if ($supir && $supir->status === 'tersedia') {
                $biaya_supir = $supir->tarif_per_hari;
                $supir->update(['status' => 'bertugas']);
            } else {
                return back()->with('error', 'Supir tidak tersedia.');
            }
        }

        $total = ($biaya_mobil + $biaya_supir) * $request->lama_sewa;
        $tgl_kembali = date('Y-m-d', strtotime($request->tanggal_pinjam . ' + ' . $request->lama_sewa . ' days'));

        Peminjaman::create([
            'mobil_id' => $mobil->id,
            'pelanggan_id' => Auth::user()->pelanggan->id,
            'supir_id' => $request->supir_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali_rencana' => $tgl_kembali,
            'lama_sewa' => $request->lama_sewa,
            'harga_total' => $total,
            'status' => 'menunggu_persetujuan'
        ]);

        return redirect()->route('my.rentals')->with('success', 'Permintaan sewa berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function requestReturn(Peminjaman $peminjaman)
    {
        if ($peminjaman->pelanggan_id != Auth::user()->pelanggan->id) {
            abort(403);
        }

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Status peminjaman tidak valid untuk pengembalian.');
        }

        $peminjaman->update(['status' => 'menunggu_persetujuan_pengembalian']);

        return back()->with('success', 'Permintaan pengembalian dikirim ke admin. Menunggu persetujuan.');
    }
}

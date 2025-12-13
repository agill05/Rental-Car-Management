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

        return view('user.my_rentals', compact('rentals'));
    }

    public function createRental(Mobil $mobil)
    {
        if($mobil->status !== 'tersedia') {
            return back()->with('error', 'Mobil ini tidak tersedia.');
        }

        $supirs = Supir::where('status', 'tersedia')->get();
        return view('user.rental_create', compact('mobil', 'supirs'));
    }

    public function storeRental(Request $request)
    {
        $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'lama_sewa' => 'required|integer|min:1',
        ]);

        $mobil = Mobil::find($request->mobil_id);
        
        $biaya_mobil = $mobil->harga_per_hari;
        $biaya_supir = 0;

        if ($request->supir_id) {
            $supir = Supir::find($request->supir_id);
            if($supir) {
                $biaya_supir = $supir->tarif_per_hari;
                $supir->update(['status' => 'bertugas']);
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
            'status' => 'dipinjam'
        ]);

        $mobil->update(['status' => 'disewa']);

        return redirect()->route('my.rentals')->with('success', 'Mobil berhasil disewa!');
    }

    public function requestReturn(Peminjaman $peminjaman)
    {
        if ($peminjaman->pelanggan_id != Auth::user()->pelanggan->id) {
            abort(403);
        }

        $peminjaman->update(['status' => 'menunggu_persetujuan']);

        return back()->with('success', 'Permintaan pengembalian dikirim.');
    }
}
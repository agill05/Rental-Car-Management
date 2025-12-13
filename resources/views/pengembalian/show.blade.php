@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Nota Pengembalian #{{ $pengembalian->id }}</h2>
        <a href="{{ route('pengembalian.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-8 bg-green-600 text-white flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold uppercase tracking-wider">BUKTI PENGEMBALIAN</h1>
                <p class="text-green-100 text-sm mt-1">ID Peminjaman: #{{ $pengembalian->peminjaman_id }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-green-100">Tanggal Kembali</p>
                <p class="text-xl font-bold">{{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali_aktual)->format('d F Y') }}</p>
            </div>
        </div>

        <div class="p-8">
            <div class="flex justify-between border-b border-gray-100 pb-8 mb-8">
                <div>
                    <h5 class="text-xs font-bold text-gray-500 uppercase mb-2">Penyewa</h5>
                    <h3 class="text-xl font-bold text-gray-900">{{ $pengembalian->peminjaman->pelanggan->nama }}</h3>
                    <p class="text-gray-600">{{ $pengembalian->peminjaman->pelanggan->alamat }}</p>
                    <p class="text-gray-600">{{ $pengembalian->peminjaman->pelanggan->no_hp }}</p>
                </div>
                <div class="text-right">
                    <h5 class="text-xs font-bold text-gray-500 uppercase mb-2">Kendaraan</h5>
                    <h3 class="text-xl font-bold text-gray-900">{{ $pengembalian->peminjaman->mobil->nama_mobil }}</h3>
                    <span class="inline-block bg-gray-100 rounded px-2 py-1 text-sm font-semibold text-gray-700 mt-1">
                        {{ $pengembalian->peminjaman->mobil->no_polisi }}
                    </span>
                </div>
            </div>

            <table class="w-full text-left mb-8">
                <thead>
                    <tr>
                        <th class="py-2 text-sm font-bold text-gray-500 uppercase border-b border-gray-200">Deskripsi</th>
                        <th class="py-2 text-sm font-bold text-gray-500 uppercase border-b border-gray-200 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="py-4 text-gray-900">
                            Biaya Sewa Awal <br>
                            <span class="text-sm text-gray-500">Durasi: {{ $pengembalian->peminjaman->lama_sewa }} Hari</span>
                        </td>
                        <td class="py-4 text-gray-900 font-medium text-right">
                            Rp {{ number_format($pengembalian->peminjaman->harga_total, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="py-4 text-red-600">
                            Denda Keterlambatan
                        </td>
                        <td class="py-4 text-red-600 font-medium text-right">
                            Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="pt-6 text-lg font-bold text-gray-900">Total Pembayaran</td>
                        <td class="pt-6 text-2xl font-bold text-green-600 text-right">
                            Rp {{ number_format($pengembalian->total_bayar_akhir, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            @if($pengembalian->catatan_kondisi)
            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h6 class="text-xs font-bold text-gray-500 uppercase mb-2">Catatan Kondisi Mobil</h6>
                <p class="text-gray-700 italic">"{{ $pengembalian->catatan_kondisi }}"</p>
            </div>
            @endif

            <div class="mt-8 flex justify-end gap-3">
                <button onclick="window.print()" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-print"></i> Cetak Nota
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
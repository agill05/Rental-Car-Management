@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Pengembalian</h2>
        <a href="{{ route('pengembalian.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 bg-yellow-500 text-white">
            <h5 class="text-lg font-semibold">Form Edit Transaksi #{{ $pengembalian->id }}</h5>
        </div>
        
        <div class="p-8">
            <form action="{{ route('pengembalian.update', $pengembalian->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Informasi Kendaraan (Read-Only)</label>
                    <input type="text" value="{{ $pengembalian->peminjaman->mobil->nama_mobil }} - {{ $pengembalian->peminjaman->pelanggan->nama }}" class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5" readonly>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="tanggal_kembali_aktual" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Kembali</label>
                        <input type="date" id="tanggal_kembali_aktual" name="tanggal_kembali_aktual" value="{{ old('tanggal_kembali_aktual', $pengembalian->tanggal_kembali_aktual) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label for="denda" class="block mb-2 text-sm font-medium text-gray-900">Denda (Rp)</label>
                        <input type="number" id="denda" name="denda" value="{{ old('denda', $pengembalian->denda) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="total_bayar_akhir" class="block mb-2 text-sm font-medium text-gray-900">Total Bayar Akhir (Rp)</label>
                    <input type="number" id="total_bayar_akhir" name="total_bayar_akhir" value="{{ old('total_bayar_akhir', $pengembalian->total_bayar_akhir) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5" required>
                    <p class="mt-1 text-xs text-gray-500">Pastikan menghitung ulang total jika mengubah denda.</p>
                </div>

                <div class="mb-6">
                    <label for="catatan_kondisi" class="block mb-2 text-sm font-medium text-gray-900">Catatan Kondisi</label>
                    <textarea id="catatan_kondisi" name="catatan_kondisi" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5">{{ old('catatan_kondisi', $pengembalian->catatan_kondisi) }}</textarea>
                </div>

                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <button type="submit" class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-lg px-8 py-2.5 flex items-center gap-2 shadow transition">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
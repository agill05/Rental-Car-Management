@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Transaksi #{{ $peminjaman->id }}</h2>
        <a href="{{ route('peminjaman.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center {{ $peminjaman->status == 'dipinjam' ? 'bg-yellow-50' : 'bg-green-50' }}">
                    <h5 class="font-semibold text-gray-700">Status Transaksi</h5>
                    @if($peminjaman->status == 'dipinjam')
                        <span class="bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1 rounded-full uppercase">Sedang Dipinjam</span>
                    @else
                        <span class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full uppercase">Selesai / Dikembalikan</span>
                    @endif
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Pinjam</p>
                            <p class="text-lg font-medium text-gray-900">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Rencana Kembali</p>
                            <p class="text-lg font-medium text-gray-900">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Lama Sewa</p>
                            <p class="text-lg font-medium text-gray-900">{{ $peminjaman->lama_sewa }} Hari</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Biaya Sewa</p>
                            <p class="text-xl font-bold text-blue-600">Rp {{ number_format($peminjaman->harga_total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                @if($peminjaman->status == 'dipinjam')
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i> Mobil belum dikembalikan.
                    </div>
                    <a href="{{ route('pengembalian.create') }}?peminjaman_id={{ $peminjaman->id }}" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 shadow hover:shadow-lg transition">
                        <i class="fas fa-undo mr-1"></i> Proses Pengembalian
                    </a>
                </div>
                @endif
            </div>

            @if($peminjaman->pengembalian)
            <div class="bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden">
                <div class="px-6 py-3 bg-green-600 text-white border-b border-green-600">
                    <h5 class="font-semibold"><i class="fas fa-check-circle mr-2"></i> Laporan Pengembalian</h5>
                </div>
                <div class="p-6">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="py-3 text-gray-500">Tanggal Kembali Aktual</td>
                                <td class="py-3 font-medium text-gray-900 text-right">{{ \Carbon\Carbon::parse($peminjaman->pengembalian->tanggal_kembali_aktual)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td class="py-3 text-gray-500">Denda Keterlambatan</td>
                                <td class="py-3 font-medium text-red-600 text-right">Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="bg-green-50">
                                <td class="py-3 px-2 font-bold text-green-800">Total Bayar Akhir</td>
                                <td class="py-3 px-2 font-bold text-green-800 text-right text-lg">Rp {{ number_format($peminjaman->pengembalian->total_bayar_akhir, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    @if($peminjaman->pengembalian->catatan_kondisi)
                    <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 uppercase mb-1">Catatan Kondisi:</p>
                        <p class="text-gray-700">{{ $peminjaman->pengembalian->catatan_kondisi }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 bg-gray-900 text-white">
                    <h6 class="text-sm font-semibold uppercase tracking-wider">Kendaraan</h6>
                </div>
                <div class="p-5">
                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $peminjaman->mobil->nama_mobil ?? 'Data Terhapus' }}</h4>
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2 py-0.5 rounded border border-gray-200">{{ $peminjaman->mobil->no_polisi ?? '-' }}</span>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100 text-sm">
                        <p class="text-gray-500">Tarif Harian:</p>
                        <p class="font-semibold text-gray-900">Rp {{ number_format($peminjaman->mobil->harga_per_hari ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 bg-gray-900 text-white">
                    <h6 class="text-sm font-semibold uppercase tracking-wider">Penyewa</h6>
                </div>
                <div class="p-5">
                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $peminjaman->pelanggan->nama ?? 'Data Terhapus' }}</h4>
                    <div class="space-y-2 mt-3 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-id-card w-6 text-center mr-2"></i>
                            <span>{{ $peminjaman->pelanggan->nik ?? '-' }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone w-6 text-center mr-2"></i>
                            <span>{{ $peminjaman->pelanggan->no_hp ?? '-' }}</span>
                        </div>
                        <div class="flex items-start text-gray-600">
                            <i class="fas fa-map-marker-alt w-6 text-center mr-2 mt-1"></i>
                            <span>{{ $peminjaman->pelanggan->alamat ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @if($peminjaman->supir)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-3 bg-gray-900 text-white">
                    <h6 class="text-sm font-semibold uppercase tracking-wider">Supir Bertugas</h6>
                </div>
                <div class="p-5">
                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $peminjaman->supir->nama }}</h4>
                    <div class="flex items-center text-gray-600 text-sm mt-2">
                        <i class="fas fa-phone w-6 text-center mr-2"></i>
                        <span>{{ $peminjaman->supir->no_hp }}</span>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex gap-2">
                <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 rounded-lg shadow transition">
                    Edit Data
                </a>
                <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin hapus transaksi ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded-lg shadow transition">
                        Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
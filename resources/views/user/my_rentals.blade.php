@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Peminjaman Saya</h1>

    {{-- Stats Cards Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 bg-blue-50 text-blue-600 rounded-lg mr-4"><i class="fas fa-car fa-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Total Sewa</p>
                <p class="text-xl font-bold text-gray-800">{{ $rentals->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center">
            <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg mr-4"><i class="fas fa-clock fa-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Sedang Berjalan</p>
                <p class="text-xl font-bold text-gray-800">{{ $rentals->whereIn('status', ['dipinjam', 'menunggu_pengembalian'])->count() }}</p>
            </div>
        </div>
    </div>

    {{-- Daftar Transaksi --}}
    <div class="space-y-6">
        @forelse($rentals as $rental)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-200">
                {{-- Header Card --}}
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row justify-between md:items-center gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-gray-500 text-sm">Order #{{ $rental->id }}</span>
                        <span class="text-gray-300">|</span>
                        <span class="text-gray-600 text-sm font-medium">{{ \Carbon\Carbon::parse($rental->created_at)->format('d M Y') }}</span>
                    </div>
                    <div>
                        {{-- Status Badge Logic --}}
                        @if($rental->status == 'dipinjam')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2 animate-pulse"></span> Sedang Dipinjam
                            </span>
                        @elseif($rental->status == 'menunggu_persetujuan')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">
                                <i class="fas fa-clock mr-2"></i> Menunggu Persetujuan Admin
                            </span>
                        @elseif($rental->status == 'menunggu_persetujuan_pengembalian')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">
                                <i class="fas fa-clock mr-2"></i> Menunggu Persetujuan Pengembalian
                            </span>
                        @elseif($rental->status == 'menunggu_pengembalian')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                <i class="fas fa-hourglass-half mr-2"></i> Menunggu Konfirmasi Pengembalian
                            </span>
                        @elseif($rental->status == 'dikembalikan')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i> Selesai
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Body Card --}}
                <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                    {{-- Info Mobil --}}
                    <div class="md:col-span-2 flex gap-4">
                        {{-- FIX: Changed flex-shrink-0 to shrink-0 --}}
                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center shrink-0 text-gray-400">
                            <i class="fas fa-car text-3xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $rental->mobil->nama_mobil }}</h3>
                            <p class="text-sm text-gray-500 mb-1">{{ $rental->mobil->no_polisi }}</p>
                            @if($rental->supir)
                                <div class="inline-flex items-center gap-1 bg-gray-100 px-2 py-1 rounded text-xs text-gray-600">
                                    <i class="fas fa-user-tie"></i> dengan Supir
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1 bg-gray-100 px-2 py-1 rounded text-xs text-gray-600">
                                    <i class="fas fa-key"></i> Lepas Kunci
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Detail Waktu --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Durasi Sewa</p>
                        <p class="font-medium text-gray-900 mb-1">{{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->format('d M Y') }}</p>
                        <p class="text-sm text-gray-500 mb-2">s/d {{ \Carbon\Carbon::parse($rental->tanggal_kembali_rencana)->format('d M Y') }}</p>
                        <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-xs font-bold">{{ $rental->lama_sewa }} Hari</span>
                    </div>

                    {{-- Total & Aksi --}}
                    <div class="flex flex-col justify-between items-end">
                        <div class="text-right">
                            <p class="text-xs text-gray-500 uppercase font-semibold mb-1">Total Biaya</p>
                            <p class="text-xl font-bold text-blue-600">Rp {{ number_format($rental->harga_total, 0, ',', '.') }}</p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-4">
                            @if($rental->status == 'dipinjam')
                                <form action="{{ route('return.request', $rental->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan mobil ini sekarang?');">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md transition flex items-center gap-2">
                                        <i class="fas fa-undo"></i> Kembalikan Mobil
                                    </button>
                                </form>
                            @elseif($rental->status == 'menunggu_persetujuan')
                                <button disabled class="bg-gray-100 text-gray-400 px-4 py-2 rounded-lg text-sm font-bold cursor-not-allowed border border-gray-200">
                                    Menunggu Admin
                                </button>
                            @elseif($rental->status == 'dikembalikan')
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline">
                                    Lihat Invoice
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-6">
                    <i class="fas fa-folder-open text-gray-300 text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada riwayat sewa</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Anda belum pernah melakukan penyewaan mobil. Yuk, cari mobil impian Anda sekarang!</p>
                <a href="{{ route('home') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-bold shadow-lg transition">
                    Mulai Sewa Mobil
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
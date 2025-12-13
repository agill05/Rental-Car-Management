@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Mobil</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Mobil::count() }}</h3>
            <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full mt-2 inline-block">Unit Tersedia</span>
        </div>
        <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
            <i class="fas fa-car fa-lg"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Pelanggan</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Pelanggan::count() }}</h3>
            <span class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full mt-2 inline-block">Terdaftar</span>
        </div>
        <div class="p-3 bg-green-50 rounded-lg text-green-600">
            <i class="fas fa-users fa-lg"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Supir</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Supir::count() }}</h3>
            <span class="text-xs text-orange-600 bg-orange-100 px-2 py-1 rounded-full mt-2 inline-block">Aktif</span>
        </div>
        <div class="p-3 bg-yellow-50 rounded-lg text-yellow-600">
            <i class="fas fa-user-tie fa-lg"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Sedang Dipinjam</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</h3>
            <span class="text-xs text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full mt-2 inline-block">Transaksi Berjalan</span>
        </div>
        <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
            <i class="fas fa-calendar-check fa-lg"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Menunggu Persetujuan</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ \App\Models\Peminjaman::where('status', 'menunggu_persetujuan')->count() }}</h3>
            <span class="text-xs text-orange-600 bg-orange-100 px-2 py-1 rounded-full mt-2 inline-block">Perlu Review</span>
        </div>
        <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
            <i class="fas fa-clock fa-lg"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h5 class="font-semibold text-gray-700">Peminjaman Terbaru</h5>
            <a href="{{ route('peminjaman.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Pelanggan</th>
                        <th class="px-6 py-3">Mobil</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse(\App\Models\Peminjaman::with(['pelanggan', 'mobil'])->latest()->take(5)->get() as $peminjaman)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium text-gray-900">{{ $peminjaman->pelanggan->nama ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $peminjaman->mobil->nama_mobil ?? '-' }}</td>
                        <td class="px-6 py-3">
                            @if($peminjaman->status == 'dipinjam')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Dipinjam</span>
                            @elseif($peminjaman->status == 'menunggu_persetujuan')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Menunggu Persetujuan</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h5 class="font-semibold text-gray-700">Pengembalian Terbaru</h5>
            <a href="{{ route('pengembalian.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Mobil</th>
                        <th class="px-6 py-3">Tgl Kembali</th>
                        <th class="px-6 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse(\App\Models\Pengembalian::with('peminjaman.mobil')->latest()->take(5)->get() as $pengembalian)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium text-gray-900">{{ $pengembalian->peminjaman->mobil->nama_mobil ?? 'N/A' }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ \Carbon\Carbon::parse($pengembalian->tanggal_kembali_aktual)->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 text-right font-bold text-green-600">
                            Rp {{ number_format($pengembalian->total_bayar_akhir, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
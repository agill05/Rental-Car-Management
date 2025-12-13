@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Mobil</h2>
        <a href="{{ route('mobils.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-col items-center pb-6 border-b border-gray-100">
                    <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mb-4 text-blue-600">
                        <i class="fas fa-car fa-3x"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $mobil->nama_mobil }}</h3>
                    <span class="text-sm text-gray-500">{{ $mobil->merek->nama_merek ?? '-' }} / {{ $mobil->jenisMobil->nama_jenis ?? '-' }}</span>
                    
                    <div class="mt-4">
                        @if($mobil->status == 'tersedia')
                            <span class="bg-green-100 text-green-800 text-sm font-medium px-4 py-1.5 rounded-full">Tersedia</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-sm font-medium px-4 py-1.5 rounded-full">Disewa</span>
                        @endif
                    </div>
                </div>
                
                <div class="mt-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Plat Nomor</span>
                        <span class="font-semibold text-gray-900 bg-gray-100 px-2 py-1 rounded border border-gray-200">{{ $mobil->no_polisi }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Tahun</span>
                        <span class="font-medium text-gray-900">{{ $mobil->tahun }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Harga Sewa</span>
                        <span class="font-bold text-green-600 text-lg">Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}<span class="text-xs text-gray-400 font-normal">/hari</span></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 text-sm">Terdaftar</span>
                        <span class="font-medium text-gray-900 text-xs">{{ $mobil->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="mt-8 flex gap-3">
                    <a href="{{ route('mobils.edit', $mobil->id) }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 rounded-lg transition shadow">
                        Edit
                    </a>
                    <form action="{{ route('mobils.destroy', $mobil->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus mobil ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded-lg transition shadow">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h5 class="font-semibold text-gray-700">Riwayat Peminjaman</h5>
                    <span class="text-xs font-semibold text-gray-500 bg-gray-200 px-2 py-1 rounded">{{ $mobil->peminjamans->count() }} Transaksi</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">Penyewa</th>
                                <th class="px-6 py-3">Tgl Pinjam</th>
                                <th class="px-6 py-3">Durasi</th>
                                <th class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($mobil->peminjamans as $pinjam)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $pinjam->pelanggan->nama ?? 'User Terhapus' }}
                                </td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">{{ $pinjam->lama_sewa }} Hari</td>
                                <td class="px-6 py-4 text-center">
                                    @if($pinjam->status == 'dipinjam')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Aktif</span>
                                    @else
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">
                                    Belum ada riwayat peminjaman untuk mobil ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
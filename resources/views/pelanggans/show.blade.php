@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Pelanggan</h2>
        <a href="{{ route('pelanggans.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-full">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold mb-4">
                        {{ substr($pelanggan->nama, 0, 1) }}
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $pelanggan->nama }}</h3>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded mt-2">Pelanggan</span>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-3 text-gray-600">
                        <div class="w-8 flex justify-center"><i class="fas fa-id-card"></i></div>
                        <span class="text-sm font-medium">{{ $pelanggan->nik }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-600">
                        <div class="w-8 flex justify-center"><i class="fas fa-phone"></i></div>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pelanggan->no_hp) }}" target="_blank" class="text-sm font-medium text-blue-600 hover:underline">
                            {{ $pelanggan->no_hp }}
                        </a>
                    </div>
                    <div class="flex items-start gap-3 text-gray-600">
                        <div class="w-8 flex justify-center mt-1"><i class="fas fa-map-marker-alt"></i></div>
                        <span class="text-sm">{{ $pelanggan->alamat }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-gray-600 pt-4 border-t border-gray-100">
                        <div class="w-8 flex justify-center"><i class="fas fa-clock"></i></div>
                        <span class="text-xs text-gray-500">Terdaftar sejak {{ $pelanggan->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('pelanggans.edit', $pelanggan->id) }}" class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 rounded-lg shadow transition">
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h5 class="font-semibold text-gray-700">Riwayat Peminjaman</h5>
                    <span class="bg-gray-200 text-gray-700 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $pelanggan->peminjamans->count() }} Transaksi</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">Mobil</th>
                                <th class="px-6 py-3">Tanggal Pinjam</th>
                                <th class="px-6 py-3">Biaya</th>
                                <th class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pelanggan->peminjamans as $pinjam)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $pinjam->mobil->nama_mobil ?? '-' }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($pinjam->harga_total, 0, ',', '.') }}</td>
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
                                    Belum ada riwayat peminjaman.
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
@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Peminjaman</h2>
    <a href="{{ route('peminjaman.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center gap-2 focus:outline-none">
        <i class="fas fa-plus"></i> Buat Peminjaman Baru
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Mobil</th>
                    <th class="px-6 py-3">Tgl Pinjam</th>
                    <th class="px-6 py-3">Lama</th>
                    <th class="px-6 py-3">Total Biaya</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($peminjamans as $index => $pinjam)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-gray-900">{{ $pinjam->pelanggan->nama ?? 'Data Terhapus' }}</div>
                        <div class="text-xs text-gray-500">{{ $pinjam->pelanggan->no_hp ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900">{{ $pinjam->mobil->nama_mobil ?? 'Data Terhapus' }}</div>
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2 py-0.5 rounded border border-gray-200">{{ $pinjam->mobil->no_polisi ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $pinjam->lama_sewa }} Hari</td>
                    <td class="px-6 py-4 font-medium text-gray-900">Rp {{ number_format($pinjam->harga_total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($pinjam->status == 'dipinjam')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Sedang Dipinjam</span>
                        @elseif($pinjam->status == 'menunggu_persetujuan')
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Menunggu Persetujuan</span>
                        @elseif($pinjam->status == 'menunggu_persetujuan_pengembalian')
                            <span class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded">Menunggu Persetujuan Pengembalian</span>
                        @elseif($pinjam->status == 'menunggu_pengembalian')
                            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">Menunggu Pengembalian</span>
                        @else
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <a href="{{ route('peminjaman.show', $pinjam->id) }}" class="px-3 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($pinjam->status == 'menunggu_persetujuan')
                                <form action="{{ route('peminjaman.approve', $pinjam->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 text-sm font-medium text-green-600 bg-white border border-gray-200 hover:bg-green-50 hover:text-green-700">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                            @elseif($pinjam->status == 'menunggu_persetujuan_pengembalian')
                                <form action="{{ route('peminjaman.approve.return', $pinjam) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-2 text-sm font-medium text-green-600 bg-white border border-gray-200 hover:bg-green-50 hover:text-green-700">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('peminjaman.destroy', $pinjam->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data peminjaman ini? Mobil akan kembali tersedia.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 text-sm font-medium text-red-600 bg-white border border-gray-200 rounded-r-lg hover:bg-red-50 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
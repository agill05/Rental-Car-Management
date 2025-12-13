@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Mobil</h2>
    <a href="{{ route('mobils.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center gap-2 focus:outline-none shadow">
        <i class="fas fa-plus"></i> Tambah Mobil
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3">Gambar</th>
                    <th class="px-6 py-3">Nama Mobil</th>
                    <th class="px-6 py-3">Plat Nomor</th>
                    <th class="px-6 py-3">Merek / Jenis</th>
                    <th class="px-6 py-3">Harga / Hari</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($mobils as $mobil)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4">
                        @if($mobil->gambar)
                            <img src="{{ asset('storage/' . $mobil->gambar) }}" alt="Foto Mobil" class="h-12 w-20 object-cover rounded border border-gray-200">
                        @else
                            <div class="h-12 w-20 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400 border border-gray-200">No Image</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $mobil->nama_mobil }}</td>
                    <td class="px-6 py-4"><span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-300">{{ $mobil->no_polisi }}</span></td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900 font-medium">{{ $mobil->merek->nama_merek ?? '-' }}</div>
                        <div class="text-xs text-gray-500">{{ $mobil->jenisMobil->nama_jenis ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($mobil->status == 'tersedia')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Tersedia</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Disewa</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <a href="{{ route('mobils.show', $mobil->id) }}" class="px-3 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('mobils.edit', $mobil->id) }}" class="px-3 py-2 text-sm font-medium text-yellow-600 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-yellow-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('mobils.destroy', $mobil->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus mobil ini?');">
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
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Data mobil belum tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
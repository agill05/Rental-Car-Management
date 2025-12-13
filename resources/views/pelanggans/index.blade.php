@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Pelanggan</h2>
    <a href="{{ route('pelanggans.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center gap-2 focus:outline-none shadow">
        <i class="fas fa-plus"></i> Tambah Pelanggan
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 w-16">No</th>
                    <th class="px-6 py-3">Nama Lengkap</th>
                    <th class="px-6 py-3">NIK (KTP)</th>
                    <th class="px-6 py-3">Kontak</th>
                    <th class="px-6 py-3">Alamat</th>
                    <th class="px-6 py-3 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pelanggans as $index => $pelanggan)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-900">{{ $pelanggan->nama }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-200">
                            {{ $pelanggan->nik }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-blue-600">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-phone text-xs"></i> {{ $pelanggan->no_hp }}
                        </div>
                    </td>
                    <td class="px-6 py-4 truncate max-w-xs">{{ Str::limit($pelanggan->alamat, 40) }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex rounded-md shadow-sm" role="group">
                            <a href="{{ route('pelanggans.show', $pelanggan->id) }}" class="px-3 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('pelanggans.edit', $pelanggan->id) }}" class="px-3 py-2 text-sm font-medium text-yellow-600 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-yellow-700">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pelanggans.destroy', $pelanggan->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pelanggan ini?');">
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
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data pelanggan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
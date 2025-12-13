@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Supir</h2>
    <a href="{{ route('supirs.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center gap-2 shadow">
        <i class="fas fa-plus"></i> Tambah Supir
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left text-sm text-gray-600">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4">Foto</th>
                <th class="px-6 py-4">Nama</th>
                <th class="px-6 py-4">Kontak</th>
                <th class="px-6 py-4">Tarif/Hari</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($supirs as $supir)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    @if($supir->foto)
                        <img src="{{ asset('storage/' . $supir->foto) }}" alt="Foto Supir" class="h-12 w-12 rounded-full object-cover border border-gray-200">
                    @else
                        <div class="h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-400"><i class="fas fa-user"></i></div>
                    @endif
                </td>
                <td class="px-6 py-4 font-bold text-gray-900">{{ $supir->nama }}</td>
                <td class="px-6 py-4">
                    <div class="text-xs">{{ $supir->no_hp }}</div>
                    <div class="text-xs text-gray-400">{{ Str::limit($supir->alamat, 20) }}</div>
                </td>
                <td class="px-6 py-4 text-green-600 font-medium">Rp {{ number_format($supir->tarif_per_hari) }}</td>
                <td class="px-6 py-4">
                    @if($supir->status == 'tersedia')
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Tersedia</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Bertugas</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('supirs.edit', $supir->id) }}" class="text-yellow-600 bg-yellow-50 px-2 py-1 rounded hover:bg-yellow-100"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('supirs.destroy', $supir->id) }}" method="POST" onsubmit="return confirm('Hapus supir ini?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 bg-red-50 px-2 py-1 rounded hover:bg-red-100"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
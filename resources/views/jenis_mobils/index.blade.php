@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Jenis Mobil</h2>
    <a href="{{ route('jenis_mobils.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Jenis
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left text-sm text-gray-600">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 font-semibold">Nama Jenis</th>
                <th class="px-6 py-4 font-semibold text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($jenisMobils as $jenis)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">{{ $jenis->nama_jenis }}</td>
                <td class="px-6 py-4 text-right flex justify-end gap-2">
                    <a href="{{ route('jenis_mobils.edit', $jenis->id) }}" class="text-yellow-600 hover:text-yellow-800 bg-yellow-50 px-3 py-1 rounded">Edit</a>
                    <form action="{{ route('jenis_mobils.destroy', $jenis->id) }}" method="POST" onsubmit="return confirm('Hapus jenis ini?');">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:text-red-800 bg-red-50 px-3 py-1 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
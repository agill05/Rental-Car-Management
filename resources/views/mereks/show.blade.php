@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Merek</h2>
        <a href="{{ route('mereks.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-2xl">
                    {{ substr($merek->nama_merek, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $merek->nama_merek }}</h1>
                    <p class="text-gray-500 text-sm">Ditambahkan pada: {{ $merek->created_at->format('d M Y') }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('mereks.edit', $merek->id) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-sm px-4 py-2 shadow transition">
                    <i class="fas fa-edit"></i> Edit Nama
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h5 class="font-semibold text-gray-700">Daftar Mobil: {{ $merek->nama_merek }}</h5>
            <span class="bg-gray-200 text-gray-700 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $merek->mobils->count() }} Unit</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">Nama Mobil</th>
                        <th class="px-6 py-3">Plat Nomor</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($merek->mobils as $mobil)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $mobil->nama_mobil }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2 py-0.5 rounded border border-gray-200">
                                {{ $mobil->no_polisi }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($mobil->status == 'tersedia')
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Tersedia</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Disewa</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('mobils.show', $mobil->id) }}" class="text-blue-600 hover:text-blue-900 hover:underline font-medium">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">
                            Belum ada mobil yang terdaftar dengan merek ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
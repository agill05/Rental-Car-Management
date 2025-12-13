@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Jenis Mobil</h2>
        <a href="{{ route('jenis_mobils.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $jenisMobil->nama_jenis }}</h1>
                <p class="text-gray-500 text-sm">ID: #{{ $jenisMobil->id }} &bull; Dibuat: {{ $jenisMobil->created_at->format('d M Y') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('jenis_mobils.edit', $jenisMobil->id) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-sm px-4 py-2 shadow">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h5 class="font-semibold text-gray-700">Daftar Mobil: {{ $jenisMobil->nama_jenis }}</h5>
            <span class="bg-gray-200 text-gray-700 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $jenisMobil->mobils->count() }} Unit</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">Mobil</th>
                        <th class="px-6 py-3">Merek</th>
                        <th class="px-6 py-3">Tahun</th>
                        <th class="px-6 py-3">Harga Sewa</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jenisMobil->mobils as $mobil)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $mobil->nama_mobil }}</td>
                        <td class="px-6 py-4">{{ $mobil->merek->nama_merek ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $mobil->tahun }}</td>
                        <td class="px-6 py-4 text-green-600 font-semibold">Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('mobils.show', $mobil->id) }}" class="text-blue-600 hover:text-blue-900 hover:underline">Lihat</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 italic">
                            Belum ada mobil yang terdaftar di kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Supir</h2>
        <a href="{{ route('supirs.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row gap-8">
            <div class="flex flex-col items-center justify-center md:w-1/3 border-b md:border-b-0 md:border-r border-gray-100 pb-6 md:pb-0">
                <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-4">
                    <i class="fas fa-user-tie fa-4x"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center">{{ $supir->nama }}</h3>
                <p class="text-sm text-gray-500 mb-3">Supir Profesional</p>
                
                @if($supir->status == 'tersedia')
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-4 py-1 rounded-full">Tersedia</span>
                @else
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-4 py-1 rounded-full">Sedang Bertugas</span>
                @endif
            </div>

            <div class="md:w-2/3 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">NIK (KTP)</p>
                        <p class="font-medium text-gray-900">{{ $supir->nik }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Nomor Handphone</p>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $supir->no_hp) }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1 font-medium">
                            <i class="fab fa-whatsapp"></i> {{ $supir->no_hp }}
                        </a>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tarif Harian</p>
                        <p class="font-bold text-green-600 text-lg">Rp {{ number_format($supir->tarif_per_hari, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Terdaftar Sejak</p>
                        <p class="font-medium text-gray-900">{{ $supir->created_at->format('d F Y') }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-500 mb-1">Alamat Lengkap</p>
                    <p class="text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-100">{{ $supir->alamat }}</p>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('supirs.edit', $supir->id) }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 rounded-lg shadow transition">
                        Edit Profil
                    </a>
                    <form action="{{ route('supirs.destroy', $supir->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus data supir ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded-lg shadow transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
    {{-- Hero Section (Banner) --}}
   <div class="relative bg-linear-to-r from-blue-700 to-blue-500 rounded-3xl overflow-hidden shadow-xl mb-10">
        <div class="absolute inset-0 bg-pattern opacity-10"></div> {{-- Placeholder pattern --}}
        <div class="relative z-10 px-8 py-16 md:py-20 text-center md:text-left grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4">
                    Sewa Mobil Mudah <br> & Terpercaya
                </h1>
                <p class="text-blue-100 text-lg mb-8 max-w-lg">
                    Temukan kendaraan impian untuk perjalanan bisnis atau liburan Anda. Harga transparan, kondisi prima, siap jalan.
                </p>
                @guest
                    <a href="{{ route('register') }}" class="inline-block bg-white text-blue-600 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-gray-100 transition transform hover:-translate-y-1">
                        Daftar Sekarang
                    </a>
                @else
                    <a href="#katalog" class="inline-block bg-yellow-400 text-yellow-900 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-yellow-300 transition transform hover:-translate-y-1">
                        Lihat Mobil
                    </a>
                @endguest
            </div>
            <div class="hidden md:flex justify-center">
                {{-- Ilustrasi Mobil (Icon FontAwesome besar sebagai placeholder) --}}
                <i class="fas fa-car-side text-white opacity-20 text-9xl transform scale-150 translate-x-10"></i>
            </div>
        </div>
    </div>

    {{-- Search / Filter Section (Opsional - Tampilan Saja) --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-10 flex flex-col md:flex-row gap-4 items-center justify-between" id="katalog">
        <div class="flex items-center gap-2 text-gray-500">
            <i class="fas fa-filter"></i>
            <span class="font-medium">Filter Kendaraan</span>
        </div>
        <div class="w-full md:w-auto flex gap-2">
            <select class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option>Semua Merek</option>
                <option>Toyota</option>
                <option>Honda</option>
            </select>
            <select class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option>Semua Tipe</option>
                <option>SUV</option>
                <option>MPV</option>
            </select>
        </div>
    </div>

    {{-- Katalog Mobil --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 border-l-4 border-blue-600 pl-3">Armada Tersedia</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($mobils as $mobil)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300 flex flex-col h-full group">
                {{-- Gambar Mobil --}}
                <div class="h-48 bg-gray-100 flex items-center justify-center relative overflow-hidden">
                    @if($mobil->gambar)
                        <img src="{{ asset('storage/' . $mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <i class="fas fa-car text-gray-300 text-6xl group-hover:scale-110 transition-transform duration-500"></i>
                    @endif
                    
                    {{-- Badge Tahun --}}
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded shadow-sm text-gray-600">
                        {{ $mobil->tahun }}
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <div class="mb-4">
                        <div class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-1">
                            {{ $mobil->merek->nama_merek ?? 'Umum' }} &bull; {{ $mobil->jenisMobil->nama_jenis ?? '-' }}
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight mb-2">{{ $mobil->nama_mobil }}</h3>
                        <div class="flex items-center gap-2">
                            <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-0.5 rounded border border-gray-200">
                                {{ $mobil->no_polisi }}
                            </span>
                        </div>
                    </div>

                    {{-- Fasilitas (Dummy) --}}
                    <div class="grid grid-cols-2 gap-y-2 text-xs text-gray-500 mb-4 border-t border-gray-100 pt-3">
                        <div class="flex items-center gap-1"><i class="fas fa-gas-pump text-blue-400"></i> Bensin</div>
                        <div class="flex items-center gap-1"><i class="fas fa-user-friends text-blue-400"></i> 4-6 Kursi</div>
                        <div class="flex items-center gap-1"><i class="fas fa-cogs text-blue-400"></i> Manual</div>
                        <div class="flex items-center gap-1"><i class="fas fa-snowflake text-blue-400"></i> AC Dingin</div>
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-400">Harga Sewa</p>
                            <p class="text-lg font-bold text-blue-600">
                                Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}
                                <span class="text-xs text-gray-400 font-normal">/hari</span>
                            </p>
                        </div>
                        
                        <a href="{{ route('rental.create', $mobil->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white p-2.5 rounded-lg shadow-md transition transform active:scale-95 flex items-center justify-center group-hover:bg-blue-700">
                            <span class="mr-2 text-sm font-bold">Sewa</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center">
                <div class="inline-block p-4 rounded-full bg-gray-100 text-gray-400 mb-3">
                    <i class="fas fa-car-crash text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada unit tersedia</h3>
                <p class="text-gray-500 text-sm">Mohon cek kembali nanti atau hubungi admin.</p>
            </div>
        @endforelse
    </div>
@endsection
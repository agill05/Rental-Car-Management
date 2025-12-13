@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Mobil Baru</h2>
        <a href="{{ route('mobils.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        {{-- Enctype Wajib untuk upload file --}}
        <form action="{{ route('mobils.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nama Mobil <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_mobil" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required placeholder="Contoh: Avanza Veloz">
                </div>
                
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nomor Polisi <span class="text-red-500">*</span></label>
                    <input type="text" name="no_polisi" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required placeholder="B 1234 CD">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Merek <span class="text-red-500">*</span></label>
                    <select name="merek_id" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required>
                        <option value="">-- Pilih Merek --</option>
                        @foreach($mereks as $merek)
                            <option value="{{ $merek->id }}">{{ $merek->nama_merek }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Jenis <span class="text-red-500">*</span></label>
                    <select name="jenis_mobil_id" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($jenisMobils as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tahun <span class="text-red-500">*</span></label>
                    <input type="number" name="tahun" value="{{ date('Y') }}" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Harga Sewa/Hari <span class="text-red-500">*</span></label>
                    <input type="number" name="harga_per_hari" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required placeholder="0">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Status Awal</label>
                    <select name="status" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5">
                        <option value="tersedia">Tersedia</option>
                        <option value="disewa">Disewa</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Foto Mobil</label>
                    <input type="file" name="gambar" accept="image/jpeg,image/png,image/gif" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG, GIF. Max: 2MB</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 shadow">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
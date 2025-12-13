@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Mobil</h2>
        <a href="{{ route('mobils.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <form action="{{ route('mobils.update', $mobil->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nama Mobil</label>
                    <input type="text" name="nama_mobil" value="{{ $mobil->nama_mobil }}" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nomor Polisi</label>
                    <input type="text" name="no_polisi" value="{{ $mobil->no_polisi }}" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Merek</label>
                    <select name="merek_id" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required>
                        @foreach($mereks as $merek)
                            <option value="{{ $merek->id }}" {{ $mobil->merek_id == $merek->id ? 'selected' : '' }}>{{ $merek->nama_merek }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Jenis</label>
                    <select name="jenis_mobil_id" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required>
                        @foreach($jenisMobils as $jenis)
                            <option value="{{ $jenis->id }}" {{ $mobil->jenis_mobil_id == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tahun</label>
                    <input type="number" name="tahun" value="{{ $mobil->tahun }}" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Harga Sewa/Hari</label>
                    <input type="number" name="harga_per_hari" value="{{ $mobil->harga_per_hari }}" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                    <select name="status" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5">
                        <option value="tersedia" {{ $mobil->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="disewa" {{ $mobil->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Foto Mobil</label>
                    
                    @if($mobil->gambar)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}" class="h-32 w-full object-cover rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                        </div>
                    @endif

                    <input type="file" name="gambar" accept="image/jpeg,image/png,image/gif" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG, GIF. Max: 2MB. Upload baru untuk mengganti. Biarkan kosong jika tidak berubah.</p>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="text-white bg-yellow-500 hover:bg-yellow-600 font-medium rounded-lg text-sm px-5 py-2.5 shadow">
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
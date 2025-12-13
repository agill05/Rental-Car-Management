@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-xl font-bold mb-6 text-gray-800">Edit Data Supir</h2>
    <form action="{{ route('supirs.update', $supir->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ $supir->nama }}" class="w-full border border-gray-300 rounded-lg p-2.5" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">NIK</label>
                <input type="number" name="nik" value="{{ $supir->nik }}" class="w-full border border-gray-300 rounded-lg p-2.5" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">No. HP</label>
                <input type="text" name="no_hp" value="{{ $supir->no_hp }}" class="w-full border border-gray-300 rounded-lg p-2.5" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tarif Per Hari (Rp)</label>
                <input type="number" name="tarif_per_hari" value="{{ $supir->tarif_per_hari }}" class="w-full border border-gray-300 rounded-lg p-2.5" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg p-2.5">
                    <option value="tersedia" {{ $supir->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="bertugas" {{ $supir->status == 'bertugas' ? 'selected' : '' }}>Bertugas</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Foto Supir</label>
                @if($supir->foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $supir->foto) }}" class="h-20 w-20 rounded-full object-cover border">
                    </div>
                @endif
                <input type="file" name="foto" accept="image/jpeg,image/png,image/gif" class="w-full border border-gray-300 rounded-lg bg-gray-50 text-sm">
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border border-gray-300 rounded-lg p-2.5" required>{{ $supir->alamat }}</textarea>
        </div>

        <button type="submit" class="w-full bg-yellow-500 text-white py-2.5 rounded-lg hover:bg-yellow-600 shadow font-medium">Update Data</button>
    </form>
</div>
@endsection
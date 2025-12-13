@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-xl font-bold mb-6 text-gray-800">Tambah Supir Baru</h2>
    <form action="{{ route('supirs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">NIK</label>
                <input type="number" name="nik" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">No. HP</label>
                <input type="text" name="no_hp" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tarif Per Hari (Rp)</label>
                <input type="number" name="tarif_per_hari" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg p-2.5">
                    <option value="tersedia">Tersedia</option>
                    <option value="bertugas">Bertugas</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Foto Supir</label>
                <input type="file" name="foto" accept="image/jpeg,image/png,image/gif" class="w-full border border-gray-300 rounded-lg bg-gray-50 text-sm">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, Max 2MB.</p>
            </div>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-blue-500" required></textarea>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 shadow font-medium">Simpan Data Supir</button>
    </form>
</div>
@endsection
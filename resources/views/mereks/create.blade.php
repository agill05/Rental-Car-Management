@extends('layouts.app')
@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-xl font-bold mb-4">Tambah Merek</h2>
    <form action="{{ route('mereks.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nama Merek</label>
            <input type="text" name="nama_merek" class="w-full border rounded-lg p-2" required>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Simpan</button>
    </form>
</div>
@endsection
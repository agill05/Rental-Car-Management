@extends('layouts.guest')

@section('content')
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Lengkapi data diri Anda untuk mulai menyewa</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 text-red-600 p-3 rounded text-sm border-l-4 border-red-500">
            <p class="font-bold">Perhatian:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <div class="space-y-4">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <h3 class="text-xs font-bold text-blue-600 uppercase mb-3">Informasi Akun</h3>
                
                <div class="mb-3">
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" 
                        placeholder="Alamat Email">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <input type="password" name="password" required 
                        class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" 
                        placeholder="Password">
                    <input type="password" name="password_confirmation" required 
                        class="w-full bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5" 
                        placeholder="Ulangi Password">
                </div>
            </div>

            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase mb-2 px-1">Data Pelanggan</h3>
                
                <div class="mb-3">
                    <label class="block mb-1 text-xs font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required 
                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Sesuai KTP">
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-700">NIK (KTP)</label>
                        <input type="number" name="nik" value="{{ old('nik') }}" required 
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="16 Digit">
                    </div>
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-700">No. HP / WA</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required 
                            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="08xxx">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="block mb-1 text-xs font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat" rows="2" required 
                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Jalan, RT/RW, Kota...">{{ old('alamat') }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="mt-6 w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-bold rounded-lg text-sm px-5 py-3 shadow-md hover:shadow-lg transition">
            Daftar Sekarang
        </button>

        <div class="mt-4 text-center text-sm">
            <span class="text-gray-500">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline ml-1">Masuk</a>
        </div>
    </form>
@endsection
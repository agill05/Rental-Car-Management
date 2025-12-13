@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Breadcrumb / Back Button --}}
    <a href="{{ route('home') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 mb-6 transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Katalog
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Kolom Kiri: Info Mobil --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                <div class="h-48 bg-gray-100 flex items-center justify-center">
                    @if($mobil->gambar)
                        <img src="{{ asset('images/mobils/' . $mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-car text-gray-300 text-6xl"></i>
                    @endif
                </div>
                <div class="p-6">
                    <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">
                        {{ $mobil->merek->nama_merek }}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $mobil->nama_mobil }}</h2>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-200">
                            {{ $mobil->no_polisi }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $mobil->tahun }}</span>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-sm text-gray-500 mb-1">Harga Sewa Dasar</p>
                        <p class="text-xl font-bold text-blue-600">
                            Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}
                            <span class="text-sm font-normal text-gray-400">/hari</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form Sewa --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Detail Penyewaan</h3>

                <form action="{{ route('rental.store') }}" method="POST" id="rentalForm">
                    @csrf
                    <input type="hidden" name="mobil_id" value="{{ $mobil->id }}">
                    {{-- Hidden input harga mobil untuk JS --}}
                    <input type="hidden" id="base_price" value="{{ $mobil->harga_per_hari }}">

                    <div class="space-y-6">
                        {{-- Tanggal Mulai --}}
                        <div>
                            <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700 mb-2">Mulai Sewa</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" 
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                    value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        {{-- Durasi --}}
                        <div>
                            <label for="lama_sewa" class="block text-sm font-medium text-gray-700 mb-2">Durasi (Hari)</label>
                            <div class="flex items-center">
                                <button type="button" onclick="adjustDuration(-1)" class="p-2 bg-gray-100 rounded-l-lg border border-gray-300 hover:bg-gray-200">
                                    <i class="fas fa-minus text-gray-500"></i>
                                </button>
                                <input type="number" name="lama_sewa" id="lama_sewa" 
                                    class="w-full text-center border-t border-b border-gray-300 focus:ring-0 z-10"
                                    value="1" min="1" readonly>
                                <button type="button" onclick="adjustDuration(1)" class="p-2 bg-gray-100 rounded-r-lg border border-gray-300 hover:bg-gray-200">
                                    <i class="fas fa-plus text-gray-500"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Opsi Supir --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Layanan Supir</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Opsi Tanpa Supir --}}
                                <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition border-blue-500 bg-blue-50" id="label_no_driver">
                                    <input type="radio" name="supir_id" value="" class="h-4 w-4 text-blue-600 focus:ring-blue-500" checked onchange="updateDriverOption(this)">
                                    <div class="ml-3">
                                        <span class="block text-sm font-medium text-gray-900">Lepas Kunci</span>
                                        <span class="block text-xs text-gray-500">Setir sendiri</span>
                                    </div>
                                </label>

                                {{-- Opsi Dengan Supir (Looping) --}}
                                @foreach($supirs as $supir)
                                <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition border-gray-200" id="label_driver_{{ $supir->id }}">
                                    <input type="radio" name="supir_id" value="{{ $supir->id }}" 
                                           data-price="{{ $supir->tarif_per_hari }}"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500" onchange="updateDriverOption(this)">
                                    <div class="ml-3">
                                        <span class="block text-sm font-medium text-gray-900">Dengan Supir</span>
                                        <span class="block text-xs text-gray-500">+ Rp {{ number_format($supir->tarif_per_hari, 0, ',', '.') }}/hari</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Ringkasan Biaya --}}
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 mt-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Total Hari</span>
                                <span class="font-semibold text-gray-900" id="summary_days">1 Hari</span>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-600">Biaya Supir</span>
                                <span class="font-semibold text-gray-900" id="summary_driver">Rp 0</span>
                            </div>
                            <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">Total Estimasi</span>
                                <span class="text-2xl font-bold text-blue-600" id="total_price">Rp 0</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:-translate-y-0.5">
                            Konfirmasi Sewa Mobil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script Kalkulator Harga --}}
<script>
    function adjustDuration(amount) {
        const input = document.getElementById('lama_sewa');
        let val = parseInt(input.value) || 1;
        val += amount;
        if (val < 1) val = 1;
        input.value = val;
        calculateTotal();
    }

    function updateDriverOption(radio) {
        // Reset styles
        document.querySelectorAll('label[id^="label_"]').forEach(el => {
            el.classList.remove('border-blue-500', 'bg-blue-50');
            el.classList.add('border-gray-200');
        });

        // Add active style
        const activeLabel = radio.closest('label');
        activeLabel.classList.remove('border-gray-200');
        activeLabel.classList.add('border-blue-500', 'bg-blue-50');

        calculateTotal();
    }

    function calculateTotal() {
        const basePrice = parseInt(document.getElementById('base_price').value) || 0;
        const duration = parseInt(document.getElementById('lama_sewa').value) || 1;
        
        // Get selected driver price
        const driverRadio = document.querySelector('input[name="supir_id"]:checked');
        let driverPrice = 0;
        if (driverRadio && driverRadio.value !== "") {
            driverPrice = parseInt(driverRadio.getAttribute('data-price')) || 0;
        }

        const totalDriverCost = driverPrice * duration;
        const totalCost = (basePrice * duration) + totalDriverCost;

        // Update UI
        document.getElementById('summary_days').textContent = duration + ' Hari';
        document.getElementById('summary_driver').textContent = 'Rp ' + totalDriverCost.toLocaleString('id-ID');
        document.getElementById('total_price').textContent = 'Rp ' + totalCost.toLocaleString('id-ID');
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endsection
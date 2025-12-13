@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Proses Pengembalian Mobil</h2>
        <a href="{{ route('pengembalian.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 bg-green-600 text-white">
            <h5 class="text-lg font-semibold">Formulir Pengembalian & Pembayaran</h5>
        </div>
        
        <div class="p-8">
            <form action="{{ route('pengembalian.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    
                    <div class="space-y-6">
                        <div class="pb-2 border-b border-gray-100">
                            <h3 class="text-lg font-medium text-gray-900">Pilih Transaksi Aktif</h3>
                        </div>

                        <div>
                            <label for="peminjaman_id" class="block mb-2 text-sm font-medium text-gray-900">Data Peminjaman <span class="text-red-500">*</span></label>
                            <select id="peminjaman_id" name="peminjaman_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                                <option value="">-- Pilih Mobil yang Dipinjam --</option>
                                @foreach($peminjamans as $pinjam)
                                    <option value="{{ $pinjam->id }}" 
                                        data-tgl-kembali="{{ $pinjam->tanggal_kembali_rencana }}"
                                        data-total-awal="{{ $pinjam->harga_total }}"
                                        data-tarif-mobil="{{ $pinjam->mobil->harga_per_hari }}"
                                        data-mobil="{{ $pinjam->mobil->nama_mobil }} - {{ $pinjam->mobil->no_polisi }}"
                                        data-pelanggan="{{ $pinjam->pelanggan->nama }}"
                                        {{ request('peminjaman_id') == $pinjam->id ? 'selected' : '' }}
                                    >
                                        #{{ $pinjam->id }} - {{ $pinjam->mobil->nama_mobil }} ({{ $pinjam->pelanggan->nama }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="infoBox" class="hidden p-4 bg-blue-50 border border-blue-100 rounded-lg">
                            <h6 class="text-sm font-bold text-blue-800 mb-2 uppercase tracking-wide">Detail Singkat</h6>
                            <div class="space-y-2 text-sm text-blue-900">
                                <div class="flex justify-between">
                                    <span class="text-blue-600">Mobil:</span>
                                    <span class="font-medium" id="infoMobil">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600">Pelanggan:</span>
                                    <span class="font-medium" id="infoPelanggan">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-blue-600">Batas Kembali:</span>
                                    <span class="font-bold" id="infoBatas">-</span>
                                </div>
                                <div class="flex justify-between border-t border-blue-200 pt-2 mt-2">
                                    <span class="text-blue-600">Biaya Awal:</span>
                                    <span class="font-bold">Rp <span id="infoBiayaAwal">0</span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="pb-2 border-b border-gray-100">
                            <h3 class="text-lg font-medium text-gray-900">Rincian Akhir</h3>
                        </div>

                        <div>
                            <label for="tanggal_kembali_aktual" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Kembali Aktual <span class="text-red-500">*</span></label>
                            <input type="date" id="tanggal_kembali_aktual" name="tanggal_kembali_aktual" value="{{ old('tanggal_kembali_aktual', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="denda" class="block mb-2 text-sm font-medium text-gray-900">Denda (Rp)</label>
                                <div class="relative">
                                    <input type="number" id="denda" name="denda" value="{{ old('denda', 0) }}" min="0" class="bg-red-50 border border-red-300 text-red-900 text-sm font-bold rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5">
                                </div>
                                <p id="infoTelat" class="hidden mt-1 text-xs text-red-600 font-medium"></p>
                            </div>
                            
                            <div>
                                <label for="total_bayar_akhir" class="block mb-2 text-sm font-medium text-gray-900">Total Bayar Akhir</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <span class="text-green-600 font-bold">Rp</span>
                                    </div>
                                    <input type="number" id="total_bayar_akhir" name="total_bayar_akhir" value="{{ old('total_bayar_akhir') }}" class="bg-green-50 border border-green-300 text-green-900 text-lg font-bold rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" readonly required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="catatan_kondisi" class="block mb-2 text-sm font-medium text-gray-900">Catatan Kondisi Mobil</label>
                            <textarea id="catatan_kondisi" name="catatan_kondisi" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Contoh: Baret halus di bumper depan, BBM full.">{{ old('catatan_kondisi') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-8 pt-6 border-t border-gray-100">
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-8 py-3 flex items-center gap-2 shadow-lg hover:shadow-xl transition duration-200">
                        <i class="fas fa-check-double"></i> Selesaikan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script Kalkulator Denda --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectPeminjaman = document.getElementById('peminjaman_id');
        const inputTglAktual = document.getElementById('tanggal_kembali_aktual');
        const inputDenda = document.getElementById('denda');
        const inputTotal = document.getElementById('total_bayar_akhir');
        
        // Elemen Info
        const infoBox = document.getElementById('infoBox');
        const infoMobil = document.getElementById('infoMobil');
        const infoPelanggan = document.getElementById('infoPelanggan');
        const infoBatas = document.getElementById('infoBatas');
        const infoBiayaAwal = document.getElementById('infoBiayaAwal');
        const infoTelat = document.getElementById('infoTelat');

        function hitungBiaya() {
            const selectedOption = selectPeminjaman.selectedOptions[0];
            
            if (!selectedOption || !selectedOption.value) {
                infoBox.classList.add('hidden');
                inputTotal.value = 0;
                return;
            }

            // Ambil data
            const batasKembali = new Date(selectedOption.getAttribute('data-tgl-kembali'));
            const biayaAwal = parseFloat(selectedOption.getAttribute('data-total-awal'));
            const tarifMobil = parseFloat(selectedOption.getAttribute('data-tarif-mobil'));
            const tglAktual = new Date(inputTglAktual.value);

            // Tampilkan Info Box
            infoBox.classList.remove('hidden');
            infoMobil.innerText = selectedOption.getAttribute('data-mobil');
            infoPelanggan.innerText = selectedOption.getAttribute('data-pelanggan');
            infoBatas.innerText = selectedOption.getAttribute('data-tgl-kembali');
            infoBiayaAwal.innerText = biayaAwal.toLocaleString('id-ID');

            // Hitung Denda
            batasKembali.setHours(0,0,0,0);
            tglAktual.setHours(0,0,0,0);

            const diffTime = tglAktual - batasKembali;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

            let dendaHitungan = 0;
            if (diffDays > 0) {
                dendaHitungan = diffDays * tarifMobil;
                infoTelat.classList.remove('hidden');
                infoTelat.innerText = `Terlambat ${diffDays} hari. Denda otomatis ditambahkan.`;
            } else {
                infoTelat.classList.add('hidden');
            }

            // Update Input
            inputDenda.value = dendaHitungan;
            
            // Hitung Total (Biaya Awal + Denda Inputan)
            const dendaFinal = parseFloat(inputDenda.value) || 0;
            inputTotal.value = biayaAwal + dendaFinal;
        }

        selectPeminjaman.addEventListener('change', hitungBiaya);
        inputTglAktual.addEventListener('change', hitungBiaya);
        inputDenda.addEventListener('input', function() {
            // Update total jika user edit denda manual
            const selectedOption = selectPeminjaman.selectedOptions[0];
            if (selectedOption) {
                const biayaAwal = parseFloat(selectedOption.getAttribute('data-total-awal'));
                const dendaFinal = parseFloat(inputDenda.value) || 0;
                inputTotal.value = biayaAwal + dendaFinal;
            }
        });

        if(selectPeminjaman.value) {
            hitungBiaya();
        }
    });
</script>
@endsection
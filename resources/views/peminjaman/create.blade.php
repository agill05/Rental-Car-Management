@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Buat Transaksi Peminjaman</h2>
        <a href="{{ route('peminjaman.index') }}" class="text-gray-600 hover:text-gray-900 font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 bg-blue-600 text-white">
            <h5 class="text-lg font-semibold">Formulir Peminjaman</h5>
        </div>
        
        <div class="p-8">
            <form action="{{ route('peminjaman.store') }}" method="POST" id="formPeminjaman">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div class="pb-2 border-b border-gray-100">
                            <h3 class="text-lg font-medium text-gray-900">Data Kendaraan & Penyewa</h3>
                        </div>

                        <div>
                            <label for="pelanggan_id" class="block mb-2 text-sm font-medium text-gray-900">Pelanggan <span class="text-red-500">*</span></label>
                            <select name="pelanggan_id" id="pelanggan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>
                                        {{ $pelanggan->nama }} - {{ $pelanggan->nik }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="mobil_id" class="block mb-2 text-sm font-medium text-gray-900">Pilih Mobil <span class="text-red-500">*</span></label>
                            <select id="mobil_id" name="mobil_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="" data-harga="0">-- Pilih Mobil Tersedia --</option>
                                @foreach($mobils as $mobil)
                                    <option value="{{ $mobil->id }}" data-harga="{{ $mobil->harga_per_hari }}" {{ old('mobil_id') == $mobil->id ? 'selected' : '' }}>
                                        {{ $mobil->nama_mobil }} - {{ $mobil->no_polisi }} (Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}/hari)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="supir_id" class="block mb-2 text-sm font-medium text-gray-900">Supir (Opsional)</label>
                            <select id="supir_id" name="supir_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="" data-harga="0">-- Tanpa Supir (Lepas Kunci) --</option>
                                @foreach($supirs as $supir)
                                    <option value="{{ $supir->id }}" data-harga="{{ $supir->tarif_per_hari }}" {{ old('supir_id') == $supir->id ? 'selected' : '' }}>
                                        {{ $supir->nama }} (Rp {{ number_format($supir->tarif_per_hari, 0, ',', '.') }}/hari)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="pb-2 border-b border-gray-100">
                            <h3 class="text-lg font-medium text-gray-900">Detail Sewa</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_pinjam" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai <span class="text-red-500">*</span></label>
                                <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>
                            
                            <div>
                                <label for="lama_sewa" class="block mb-2 text-sm font-medium text-gray-900">Lama (Hari) <span class="text-red-500">*</span></label>
                                <input type="number" id="lama_sewa" name="lama_sewa" value="{{ old('lama_sewa', 1) }}" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>
                        </div>

                        <div>
                            <label for="tanggal_kembali_rencana" class="block mb-2 text-sm font-medium text-gray-900">Rencana Kembali</label>
                            <input type="date" id="tanggal_kembali_rencana" name="tanggal_kembali_rencana" class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" readonly>
                        </div>

                        <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                            <label class="block mb-2 text-sm font-bold text-blue-800 uppercase tracking-wide">Estimasi Total Biaya</label>
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <span class="text-blue-600 font-bold text-lg">Rp</span>
                                </div>
                                <input type="number" id="harga_total" name="harga_total" class="bg-white border-2 border-blue-200 text-blue-700 text-2xl font-bold rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-12 p-3 shadow-inner" readonly required>
                            </div>
                            <p class="mt-2 text-xs text-blue-600 italic">*Dihitung dari (Harga Mobil + Supir) x Hari</p>
                        </div>
                        
                        <input type="hidden" name="status" value="dipinjam">
                    </div>
                </div>

                <div class="flex justify-end mt-8 pt-6 border-t border-gray-100">
                    <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-8 py-3 flex items-center gap-2 shadow-lg hover:shadow-xl transition duration-200">
                        <i class="fas fa-check-circle"></i> Proses Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT CALCULATOR --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobilSelect = document.getElementById('mobil_id');
        const supirSelect = document.getElementById('supir_id');
        const lamaInput = document.getElementById('lama_sewa');
        const tglPinjamInput = document.getElementById('tanggal_pinjam');
        
        const tglKembaliInput = document.getElementById('tanggal_kembali_rencana');
        const totalHargaInput = document.getElementById('harga_total');

        function hitungTotal() {
            const hargaMobil = parseFloat(mobilSelect.selectedOptions[0].getAttribute('data-harga')) || 0;
            const hargaSupir = parseFloat(supirSelect.selectedOptions[0].getAttribute('data-harga')) || 0;
            const lamaSewa = parseInt(lamaInput.value) || 0;

            // Hitung Harga
            const total = (hargaMobil + hargaSupir) * lamaSewa;
            totalHargaInput.value = total;

            // Hitung Tanggal Kembali
            if (tglPinjamInput.value) {
                const tglMulai = new Date(tglPinjamInput.value);
                tglMulai.setDate(tglMulai.getDate() + lamaSewa);
                
                // Format ke YYYY-MM-DD
                const yyyy = tglMulai.getFullYear();
                const mm = String(tglMulai.getMonth() + 1).padStart(2, '0');
                const dd = String(tglMulai.getDate()).padStart(2, '0');
                
                tglKembaliInput.value = `${yyyy}-${mm}-${dd}`;
            }
        }

        // Event Listeners
        mobilSelect.addEventListener('change', hitungTotal);
        supirSelect.addEventListener('change', hitungTotal);
        lamaInput.addEventListener('input', hitungTotal);
        tglPinjamInput.addEventListener('change', hitungTotal);

        // Jalankan sekali saat load
        hitungTotal();
    });
</script>
@endsection
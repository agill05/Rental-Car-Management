<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Rental #{{ $peminjaman->id }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .receipt {
            width: 300px;
            margin: 0 auto;
            background-color: white;
            border: 1px solid #ccc;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        .underline {
            text-decoration: underline;
        }
        .dotted-line {
            border-bottom: 1px dotted #000;
            margin: 5px 0;
        }
        .total-line {
            border-top: 2px solid #000;
            margin: 5px 0;
            padding-top: 5px;
        }
        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .print-button:hover {
            background-color: #0056b3;
        }
        @media print {
            body {
                background-color: white;
            }
            .receipt {
                box-shadow: none;
                border: none;
            }
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="center bold">
            RENTAL CAR MANAGEMENT<br>
            STRUK PENYEWAAN MOBIL<br>
            ============================
        </div>

        <br>

        <div>
            No. Transaksi: #{{ str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) }}<br>
            Tanggal: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y H:i') }}<br>
            Status: {{ ucfirst($peminjaman->status) }}
        </div>

        <div class="dotted-line"></div>

        <div>
            <div class="bold">Data Penyewa:</div>
            Nama: {{ $peminjaman->pelanggan->nama }}<br>
            No. HP: {{ $peminjaman->pelanggan->no_hp }}<br>
            Alamat: {{ $peminjaman->pelanggan->alamat }}
        </div>

        <div class="dotted-line"></div>

        <div>
            <div class="bold">Detail Kendaraan:</div>
            Mobil: {{ $peminjaman->mobil->nama_mobil }}<br>
            Merek: {{ $peminjaman->mobil->merek->nama_merek }}<br>
            No. Polisi: {{ $peminjaman->mobil->no_polisi }}<br>
            @if($peminjaman->supir)
            Supir: {{ $peminjaman->supir->nama }}
            @endif
        </div>

        <div class="dotted-line"></div>

        <div>
            <div class="bold">Detail Sewa:</div>
            Tanggal Pinjam: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}<br>
            Tanggal Kembali: {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d/m/Y') }}<br>
            Lama Sewa: {{ $peminjaman->lama_sewa }} hari
        </div>

        <div class="dotted-line"></div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td>Biaya Mobil/hari</td>
                <td class="right">Rp {{ number_format($peminjaman->mobil->harga_per_hari, 0, ',', '.') }}</td>
            </tr>
            @if($peminjaman->supir)
            <tr>
                <td>Biaya Supir/hari</td>
                <td class="right">Rp {{ number_format($peminjaman->supir->tarif_per_hari, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr>
                <td>Lama Sewa</td>
                <td class="right">{{ $peminjaman->lama_sewa }} hari</td>
            </tr>
        </table>

        <div class="total-line"></div>

        <div class="bold">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td>TOTAL PEMBAYARAN</td>
                    <td class="right">Rp {{ number_format($peminjaman->harga_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="dotted-line"></div>

        <div class="center">
            Terima Kasih Atas Kunjungan Anda<br>
            Simpan Struk Ini Sebagai Bukti<br>
            ============================
        </div>

        <br>

        <div class="center">
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
        </div>
    </div>

    <button class="print-button" onclick="window.print()">Cetak Struk</button>
</body>
</html>

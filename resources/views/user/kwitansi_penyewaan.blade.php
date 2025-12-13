<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Rental #{{ $peminjaman->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            background-color: #fff;
        }

        /* Header Layout */
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
            font-weight: bold;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        /* Heading Styles */
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 18px;
        }
        
        .text-right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        /* Signature Section */
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 40%;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #333;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            background: #eee;
            border-radius: 4px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
        }

        /* Button Style */
        .print-button {
            display: block;
            margin: 20px auto;
            padding: 12px 24px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            width: 200px;
        }
        .print-button:hover {
            background-color: #1a252f;
        }

        /* Print Media Query */
        @media print {
            body { 
                background-color: #fff; 
                padding: 0;
            }
            .invoice-box {
                box-shadow: none;
                border: 0;
                width: 100%;
                max-width: none;
                padding: 0;
            }
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                RENTAL CAR <span style="font-size: 16px; display:block; font-weight:normal; color: #777;">Management System</span>
                            </td>
                            <td class="text-right">
                                <strong>INVOICE: #{{ str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) }}</strong><br>
                                Tanggal: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d F Y') }}<br>
                                Status: <span class="status-badge">{{ ucfirst($peminjaman->status) }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>PENYEWA (Customer):</strong><br>
                                {{ $peminjaman->pelanggan->nama }}<br>
                                {{ $peminjaman->pelanggan->alamat }}<br>
                                HP: {{ $peminjaman->pelanggan->no_hp }}<br>
                                NIK: {{ $peminjaman->pelanggan->nik }}
                            </td>
                            <td class="text-right">
                                <strong>INFO RENTAL:</strong><br>
                                Tgl Ambil: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}<br>
                                Tgl Kembali: {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali_rencana)->format('d/m/Y') }}<br>
                                Durasi: {{ $peminjaman->lama_sewa }} Hari
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Deskripsi Item</td>
                <td class="text-right">Biaya</td>
            </tr>

            <tr class="item">
                <td>
                    <strong>{{ $peminjaman->mobil->merek->nama_merek }} - {{ $peminjaman->mobil->nama_mobil }}</strong><br>
                    <small>No. Polisi: {{ $peminjaman->mobil->no_polisi }} ({{ $peminjaman->lama_sewa }} Hari x Rp {{ number_format($peminjaman->mobil->harga_per_hari, 0, ',', '.') }})</small>
                </td>
                <td class="text-right">
                    Rp {{ number_format($peminjaman->mobil->harga_per_hari * $peminjaman->lama_sewa, 0, ',', '.') }}
                </td>
            </tr>

            @if($peminjaman->supir)
            <tr class="item">
                <td>
                    <strong>Jasa Supir</strong><br>
                    <small>Nama: {{ $peminjaman->supir->nama }} ({{ $peminjaman->lama_sewa }} Hari x Rp {{ number_format($peminjaman->supir->tarif_per_hari, 0, ',', '.') }})</small>
                </td>
                <td class="text-right">
                    Rp {{ number_format($peminjaman->supir->tarif_per_hari * $peminjaman->lama_sewa, 0, ',', '.') }}
                </td>
            </tr>
            @endif

            <tr class="total">
                <td></td>
                <td class="text-right">
                    Total: Rp {{ number_format($peminjaman->harga_total, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 30px; font-size: 12px; color: #777;">
            <p><strong>Syarat & Ketentuan:</strong></p>
            <ul>
                <li>Harap mengembalikan mobil tepat waktu. Keterlambatan akan dikenakan denda.</li>
                <li>Mobil dikembalikan dalam keadaan bersih dan bahan bakar sesuai posisi awal.</li>
                <li>Simpan struk ini sebagai bukti pembayaran dan pengambilan kendaraan yang sah.</li>
            </ul>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <p>Hormat Kami,<br>(Admin)</p>
                <div class="signature-line"></div>
            </div>
            <div class="signature-box">
                <p>Penyewa,<br>(Customer)</p>
                <div class="signature-line"></div>
            </div>
        </div>

        <div class="center" style="margin-top: 40px; font-size: 10px; color: #aaa;">
            Dicetak otomatis oleh sistem pada {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
        </div>
    </div>

    <button class="print-button" onclick="window.print()">Cetak Struk</button>
</body>
</html>
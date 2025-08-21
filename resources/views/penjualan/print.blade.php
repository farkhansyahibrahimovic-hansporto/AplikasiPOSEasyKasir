<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Penjualan #{{ $penjualan->PenjualanID }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
            color: #333;
            font-size: 28px;
        }
        .invoice-header p {
            margin: 5px 0;
            color: #666;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-details div {
            flex: 1;
        }
        .invoice-details h3 {
            margin-top: 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            color: #333;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .invoice-items table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-items th, .invoice-items td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .invoice-items th {
            background-color: #f5f5f5;
        }
        .invoice-total {
            margin-top: 30px;
            text-align: right;
        }
        .invoice-total table {
            width: 300px;
            margin-left: auto;
            border-collapse: collapse;
        }
        .invoice-total th, .invoice-total td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .invoice-total th {
            text-align: left;
            background-color: #f5f5f5;
        }
        .invoice-total td {
            text-align: right;
        }
        .invoice-notes {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .invoice-footer {
            margin-top: 50px;
            text-align: center;
            color: #888;
            font-size: 12px;
        }
        .signature-section {
            margin-top: 80px;
            display: flex;
            justify-content: space-between;
        }
        .signature-block {
            width: 200px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
        }
        @media print {
            body {
                padding: 0;
                background-color: white;
            }
            .invoice-container {
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print();" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Cetak Invoice</button>
        <button onclick="window.close();" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>
    
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>INVOICE</h1>
            <p>Easy Kasir</p>
            <p>Telp: (021) 123-4567 | Email: infoeasykasir@tokolaravel.com</p>
        </div>
        
        <div class="invoice-details">
            <div>
                <h3>Detail Penjualan</h3>
                <p><strong>No. Invoice:</strong> INV-{{ $penjualan->PenjualanID }}</p>
                <p><strong>Tanggal:</strong> {{ Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d/m/Y') }}</p>
                <p><strong>Petugas:</strong> {{ $penjualan->detailPenjualan[0]->petugas->name }}</p>
            </div>
            
            <div>
                <h3>Pelanggan</h3>
                <p><strong>Nama:</strong> {{ $penjualan->pelanggan->NamaPelanggan }}</p>
                <p><strong>Alamat:</strong> {{ $penjualan->pelanggan->Alamat }}</p>
                <p><strong>Telepon:</strong> {{ $penjualan->pelanggan->NomorTelepon }}</p>
            </div>
        </div>
        
        <div class="invoice-items">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="40%">Nama Produk</th>
                        <th width="15%">Harga</th>
                        <th width="10%">Jumlah</th>
                        <th width="30%">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->detailPenjualan as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->produk->NamaProduk }}</td>
                            <td>Rp {{ number_format($detail->produk->Harga, 0, ',', '.') }}</td>
                            <td>{{ $detail->JumlahProduk }}</td>
                            <td>Rp {{ number_format($detail->Subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="invoice-total">
            <table>
                <tr>
                    <th>Total</th>
                    <td>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        
        <div class="invoice-notes">
            <p><strong>Catatan:</strong></p>
            <p>Terima kasih telah berbelanja di toko kami. Barang yang sudah dibeli dapat dikenmbalikan maksimal 1 kali 24 jam dengan membawa nota pembelian dan produk tidak memiliki cacat dibagian apapun.</p>
        </div>
        
        <div class="signature-section">
            <div class="signature-block">
                <div class="signature-line"></div>
                <p>Petugas</p>
                <p>{{ $penjualan->detailPenjualan[0]->petugas->name }}</p>
            </div>
            
            <div class="signature-block">
                <div class="signature-line"></div>
                <p>Pelanggan</p>
                <p>{{ $penjualan->pelanggan->NamaPelanggan }}</p>
            </div>
        </div>
        
        <div class="invoice-footer">
            <p>Invoice ini sah dan diproses secara elektronik.</p>
            <p>© {{ date('Y') }} Toko Kasir Laravel. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
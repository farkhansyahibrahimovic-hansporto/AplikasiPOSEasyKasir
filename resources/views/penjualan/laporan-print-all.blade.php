<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Lengkap Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }
        
        /* Info Filter */
        .filter-info {
            background-color: #f5f5f5;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 13px;
        }
        .filter-info p {
            margin: 3px 0;
        }
        
        /* Ringkasan */
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .summary-item {
            background-color: #f1f1f1;
            padding: 8px 12px;
            border-radius: 4px;
            flex: 1;
            min-width: 150px;
        }
        .summary-item h3 {
            margin: 0 0 3px 0;
            font-size: 14px;
            color: #555;
        }
        .summary-item p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        
        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Grup Tanggal */
        .date-group {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .date-header {
            background-color: #e9ecef;
            padding: 6px 12px;
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }
        
        /* Alignment */
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        
        /* Tidak Ada Data */
        .no-data {
            text-align: center;
            padding: 20px;
            color: #777;
        }
        
        /* Tombol Aksi */
        .no-print {
            text-align: center;
            margin-bottom: 15px;
        }
        .no-print button {
            padding: 8px 16px;
            margin: 3px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-print {
            background-color: #4CAF50;
            color: white;
        }
        .btn-close {
            background-color: #f44336;
            color: white;
        }
        
        /* Cetak */
        @page {
            size: A4;
            margin: 10mm;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
            .date-group {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Aksi -->
    <div class="no-print">
        <button class="btn-print" onclick="window.print()">Cetak / Download PDF</button>
        <button class="btn-close" onclick="window.close()">Tutup</button>
    </div>

    <!-- Header Laporan -->
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <!-- Info Filter -->
    @if($filterInfo['start_date'] || $filterInfo['end_date'] || $filterInfo['pelanggan_id'] || $filterInfo['petugas_id'])
    <div class="filter-info">
        <p><strong>Filter yang digunakan:</strong></p>
        @if($filterInfo['start_date'] || $filterInfo['end_date'])
        <p>
            Tanggal:
            {{ $filterInfo['start_date'] ? date('d/m/Y', strtotime($filterInfo['start_date'])) : 'Awal' }}
            -
            {{ $filterInfo['end_date'] ? date('d/m/Y', strtotime($filterInfo['end_date'])) : 'Akhir' }}
        </p>
        @endif
        @if($filterInfo['pelanggan_id'])
        <p>Pelanggan: {{ $filterInfo['pelanggan_nama'] }}</p>
        @endif
        @if($filterInfo['petugas_id'])
        <p>Petugas: {{ $filterInfo['petugas_nama'] }}</p>
        @endif
    </div>
    @endif

    <!-- Ringkasan Statistik -->
    <div class="summary">
        <div class="summary-item">
            <h3>Total Transaksi</h3>
            <p>{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
        </div>
        <div class="summary-item">
            <h3>Total Produk Terjual</h3>
            <p>{{ number_format($totalItem, 0, ',', '.') }}</p>
        </div>
        <div class="summary-item">
            <h3>Total Pendapatan</h3>
            <p>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Data Penjualan -->
    @if($semuaPenjualan->isEmpty())
        <div class="no-data">
            <p>Tidak ada data penjualan yang ditemukan</p>
        </div>
    @else
        @foreach($groupedPenjualan as $date => $penjualanGroup)
            <div class="date-group">
                <div class="date-header">
                    {{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Pelanggan</th>
                            <th width="15%">Petugas</th>
                            <th width="15%" class="text-center">Produk</th>
                            <th width="15%" class="text-center">Qty</th>
                            <th width="15%" class="text-right">Subtotal</th>
                            <th width="15%" class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualanGroup as $index => $penjualan)
                            @php
                                $rowspan = count($penjualan->detailPenjualan);
                            @endphp
                            
                            @foreach($penjualan->detailPenjualan as $detailIndex => $detail)
                                <tr>
                                    @if($detailIndex === 0)
                                        <td rowspan="{{ $rowspan }}">{{ $loop->parent->index + 1 }}</td>
                                        <td rowspan="{{ $rowspan }}">{{ $penjualan->pelanggan->NamaPelanggan }}</td>
                                    @endif
                                    
                                    <td>{{ $detail->petugas->name }}</td>
                                    <td>{{ $detail->produk->NamaProduk }}</td>
                                    <td class="text-center">{{ $detail->JumlahProduk }}</td>
                                    <td class="text-right">Rp {{ number_format($detail->Subtotal, 0, ',', '.') }}</td>
                                    
                                    @if($detailIndex === 0)
                                        <td rowspan="{{ $rowspan }}" class="text-right">Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif

    <!-- Footer -->
    <div style="margin-top: 20px; text-align: right; font-size: 13px; color: #666;">
        <p>Dicetak oleh: {{ auth()->user()->name }}</p>
    </div>

    <script>
        // Auto buka dialog print saat halaman terbuka
        window.onload = function() {
            window.print();
        };
    </script>

</body>
</html>
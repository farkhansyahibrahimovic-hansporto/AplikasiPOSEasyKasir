@extends(auth()->user()->role == 'administrator' ? 'layouts.admin' : 'layouts.petugas')
@section('content')
<div class="container-fluid py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Detail Penjualan - Transaksi #{{ $penjualan->PenjualanID }}</h5>
            <div>
                <a href="{{ route('penjualan.print', $penjualan->PenjualanID) }}" class="btn btn-light btn-sm" target="_blank">
                    <i class="fas fa-print"></i> Cetak
                </a>
                <a href="javascript:history.back()" class="btn btn-outline-light btn-sm ms-1">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <div class="row g-3 mb-4">
                <!-- Informasi Penjualan & Pelanggan dalam satu baris responsive -->
                <div class="col-md-6">
                    <div class="card h-100 border shadow-sm">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">Informasi Penjualan</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%" class="border-0">ID Penjualan</th>
                                    <td class="border-0">{{ $penjualan->PenjualanID }}</td>
                                </tr>
                                <tr>
                                    <th class="border-0">Tanggal</th>
                                    <td class="border-0">{{ Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="border-0">Total Harga</th>
                                    <td class="border-0 fw-bold">Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card h-100 border shadow-sm">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">Informasi Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tr>
                                    <th width="40%" class="border-0">Nama</th>
                                    <td class="border-0">{{ $penjualan->pelanggan->NamaPelanggan }}</td>
                                </tr>
                                <tr>
                                    <th class="border-0">Alamat</th>
                                    <td class="border-0">{{ $penjualan->pelanggan->Alamat }}</td>
                                </tr>
                                <tr>
                                    <th class="border-0">No. Telepon</th>
                                    <td class="border-0">{{ $penjualan->pelanggan->NomorTelepon }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Detail Produk - Tabel yang menyatu dan responsif -->
            <div class="table-responsive">
                <table class="table table-hover table-striped border">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="px-3" width="5%">No</th>
                            <th width="30%">Nama Produk</th>
                            <th width="15%">Harga</th>
                            <th width="10%">Qty</th>
                            <th width="20%">Subtotal</th>
                            <th width="20%">Petugas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualan->detailPenjualan as $index => $detail)
                            <tr>
                                <td class="px-3">{{ $index + 1 }}</td>
                                <td>{{ $detail->produk->NamaProduk }}</td>
                                <td>Rp {{ number_format($detail->produk->Harga, 0, ',', '.') }}</td>
                                <td>{{ $detail->JumlahProduk }}</td>
                                <td>Rp {{ number_format($detail->Subtotal, 0, ',', '.') }}</td>
                                <td>{{ $detail->petugas->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-3">Tidak ada data detail penjualan</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-primary text-white">
                        <tr>
                            <th colspan="4" class="text-end">Total Harga:</th>
                            <th colspan="2" class="fw-bold">Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
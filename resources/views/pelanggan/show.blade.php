@extends('layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Header Sederhana -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-user me-2"></i>Detail Pelanggan
        </h4>
        <div>
            <a href="{{ route('pelanggan.edit', $pelanggan->PelangganID) }}" class="btn btn-sm btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <button onclick="window.history.back()" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
        </div>
    </div>

    <!-- Kartu Informasi Pelanggan -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <dl class="mb-0">
                        <dt class="small text-muted">ID Pelanggan</dt>
                        <dd>{{ $pelanggan->PelangganID }}</dd>
                        
                        <dt class="small text-muted mt-2">Nama</dt>
                        <dd>{{ $pelanggan->NamaPelanggan }}</dd>
                    </dl>
                </div>
                <div class="col-12 col-md-6">
                    <dl class="mb-0">
                        <dt class="small text-muted">Alamat</dt>
                        <dd>{{ $pelanggan->Alamat ?: '-' }}</dd>
                        
                        <dt class="small text-muted mt-2">Telepon</dt>
                        <dd>{{ $pelanggan->NomorTelepon ?: '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Transaksi -->
    <h5 class="mb-3">
        <i class="fas fa-history me-2"></i>Riwayat Pembelian
    </h5>
    
    @if($pelanggan->penjualan->count() > 0)
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Tanggal</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggan->penjualan as $penjualan)
                        <tr>
                            <td>TRX-{{ $penjualan->PenjualanID }}</td>
                            <td>{{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d/m/Y') }}</td>
                            <td class="text-end">Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('penjualan.show', $penjualan->PenjualanID) }}" 
                                   class="btn btn-xs btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>Belum ada riwayat pembelian
    </div>
    @endif
</div>

<style>
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 4px;
    }
    .table th {
        font-size: 0.85rem;
        padding: 0.75rem;
    }
    .table td {
        padding: 0.75rem;
        vertical-align: middle;
    }
    .btn-xs {
        padding: 0.2rem 0.4rem;
        font-size: 0.75rem;
    }
    @media (max-width: 576px) {
        .d-flex {
            flex-direction: column;
            align-items: flex-start;
        }
        .d-flex > div {
            margin-top: 10px;
        }
        .col-12 {
            padding: 0;
        }
        .table-responsive {
            font-size: 0.85rem;
        }
    }
</style>
@endsection
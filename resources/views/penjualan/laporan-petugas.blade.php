@extends(auth()->user()->role == 'administrator' ? 'layouts.admin' : 'layouts.petugas')

@section('title', 'Dashboard Performa Petugas')

@section('content')
<div class="container-fluid"> 
    <div class="row mb-4"> 
        <div class="col-12"> 
            <div class="card shadow"> 
                <div class="card-header bg-primary text-white"> 
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Dashboard Performa Petugas</h5>
                        <!-- Tombol Cetak Semua Data -->
                        <a href="{{ route('penjualan.laporan.print-all', request()->query()) }}" 
                           class="btn btn-light btn-sm" 
                           target="_blank"
                           title="Cetak Seluruh Data Penjualan">
                            <i class="fas fa-print me-1"></i>
                            Cetak Laporan Lengkap
                        </a>
                    </div>
                </div> 
                <div class="card-body">
                    @if(session('success')) 
                    <div class="alert alert-success alert-dismissible fade show" role="alert"> 
                        <div class="d-flex align-items-center"> 
                            <i class="fas fa-check-circle me-2"></i> 
                            <div>{{ session('success') }}</div> 
                        </div> 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> 
                    </div> 
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filter Section -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-filter text-primary me-2"></i>
                                    Filter Data Penjualan
                                </h6>
                                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                        <div class="collapse show" id="filterCollapse">
                            <div class="card-body">
                                <form method="GET" action="{{ route('penjualan.laporan.petugas') }}" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                                        <input type="date" 
                                               class="form-control" 
                                               id="start_date" 
                                               name="start_date" 
                                               value="{{ $filterInfo['start_date'] ?? '' }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                                        <input type="date" 
                                               class="form-control" 
                                               id="end_date" 
                                               name="end_date" 
                                               value="{{ $filterInfo['end_date'] ?? '' }}">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="btn-group w-100" role="group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-filter me-1"></i>
                                                Filter
                                            </button>
                                            <a href="{{ route('penjualan.laporan.petugas') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-times me-1"></i>
                                                Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                                
                                <!-- Filter Info -->
                                @if($filterInfo['start_date'] || $filterInfo['end_date'])
                                <div class="mt-3 p-2 bg-info bg-opacity-10 rounded">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Filter aktif: 
                                        @if($filterInfo['start_date'] && $filterInfo['end_date'])
                                            {{ \Carbon\Carbon::parse($filterInfo['start_date'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($filterInfo['end_date'])->format('d/m/Y') }}
                                        @elseif($filterInfo['start_date'])
                                            Dari {{ \Carbon\Carbon::parse($filterInfo['start_date'])->format('d/m/Y') }}
                                        @elseif($filterInfo['end_date'])
                                            Sampai {{ \Carbon\Carbon::parse($filterInfo['end_date'])->format('d/m/Y') }}
                                        @endif
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                
                    <!-- Summary Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4 col-sm-6">
                            <div class="card border-0 shadow-sm h-100 bg-light-hover">
                                <div class="card-body d-flex justify-content-between">
                                    <div>
                                        <div class="text-muted small">Petugas Aktif</div>
                                        <div class="h4 mb-0">{{ $laporanPetugas->count() }}</div>
                                    </div>
                                    <div>
                                        <i class="fas fa-user-friends text-primary fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="card border-0 shadow-sm h-100 bg-light-hover">
                                <div class="card-body d-flex justify-content-between">
                                    <div>
                                        <div class="text-muted small">Total Transaksi</div>
                                        <div class="h4 mb-0">{{ $laporanPetugas->sum('total_transaksi') }}</div>
                                    </div>
                                    <div>
                                        <i class="fas fa-shopping-cart text-success fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="card border-0 shadow-sm h-100 bg-light-hover">
                                <div class="card-body d-flex justify-content-between">
                                    <div>
                                        <div class="text-muted small">Total Pendapatan</div>
                                        <div class="h4 mb-0">{{ number_format($laporanPetugas->sum('total_penjualan'), 0, ',', '.') }}</div>
                                    </div>
                                    <div>
                                        <span class="text-info fa-2x fw-bold">Rp</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Data Table -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users text-primary me-2"></i>
                                    <h6 class="mb-0">Daftar Performa Petugas</h6>
                                </div>
                                <div id="alertContainer">
                                    <!-- Dynamic alerts will appear here -->
                                </div>
                            </div>
                        
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="30%">Nama Petugas</th>
                                            <th class="text-center" width="20%">Total Transaksi</th>
                                            <th class="text-end" width="30%">Total Penjualan</th>
                                            <th class="text-center" width="15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($laporanPetugas as $index => $laporan)
                                            <tr data-id="{{ $laporan->id }}" class="sales-row">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            {{ substr($laporan->name, 0, 1) }}
                                                        </div>
                                                        <div>{{ $laporan->name }}</div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary">{{ $laporan->total_transaksi }}</span>
                                                </td>
                                                <td class="text-end fw-bold text-success">
                                                    Rp {{ number_format($laporan->total_penjualan, 0, ',', '.') }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <a href="{{ route('penjualan.petugas.detail', [$laporan->id] + request()->query()) }}" class="btn btn-sm btn-info btn-action">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                                                        <p class="mb-0">Tidak ada data penjualan</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
                    <!-- Daily Sales -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-day text-primary me-2"></i>
                                    <h6 class="mb-0">Penjualan Harian</h6>
                                </div>
                            </div>
                        
                            <!-- Sales Data Grouped by Date -->
                            <div class="sales-data-container">
                                @forelse($groupedPenjualan as $date => $penjualanGroup)
                                    <div class="date-group mb-4">
                                        <div class="bg-light p-3 rounded mb-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <div>
                                                <i class="fas fa-calendar-day text-primary me-2"></i>
                                                <span class="fw-bold">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                                            </div>
                                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                                <span class="badge bg-primary">{{ $penjualanGroup->count() }} Transaksi</span>
                                                <span class="badge bg-info text-dark">{{ $penjualanGroup->sum(function($p) { return $p->detailPenjualan->sum('JumlahProduk'); }) }} Produk</span>
                                                <span class="badge bg-warning text-dark">{{ $penjualanGroup->flatMap(function($p) { return $p->detailPenjualan->pluck('user_id'); })->unique()->count() }} Petugas</span>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Pelanggan</th>
                                                        <th class="text-center">Produk</th>
                                                        <th class="text-end">Total</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($penjualanGroup as $penjualan)
                                                        <tr data-id="{{ $penjualan->PenjualanID }}" class="sales-row">
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fas fa-user-circle text-secondary me-2"></i>
                                                                    <div>
                                                                        <div>{{ $penjualan->pelanggan->NamaPelanggan }}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge bg-light text-dark border">
                                                                    {{ $penjualan->detailPenjualan->sum('JumlahProduk') }} item
                                                                </span>
                                                            </td>
                                                            <td class="text-end fw-bold text-success">
                                                                Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}
                                                            </td>
                                                            <td>
                                                                <div class="d-flex gap-1 justify-content-center">
                                                                    <a href="{{ route('penjualan.show', $penjualan->PenjualanID) }}" class="btn btn-sm btn-info btn-action">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('penjualan.print', $penjualan->PenjualanID) }}" class="btn btn-sm btn-success btn-action" target="_blank">
                                                                        <i class="fas fa-print"></i>
                                                                    </a>
                                                                    @if(auth()->user()->role == 'administrator')
                                                                    <a href="{{ route('penjualan.delete.confirm', $penjualan->PenjualanID) }}" class="btn btn-sm btn-danger btn-action">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @empty 
                                    <div class="text-center py-5" id="noDataContainer"> 
                                        <i class="fas fa-shopping-cart text-muted fa-3x mb-3"></i> 
                                        <h5 class="text-muted">Belum Ada Transaksi Penjualan</h5> 
                                        <p class="text-muted mb-3">
                                            @if($filterInfo['start_date'] || $filterInfo['end_date'])
                                                Tidak ada transaksi penjualan yang ditemukan pada periode yang dipilih.
                                            @else
                                                Saat ini belum ada transaksi penjualan yang tercatat dalam sistem.
                                            @endif
                                        </p> 
                                        <a href="{{ route('penjualan.create') }}" class="btn btn-primary"> 
                                            <i class="fas fa-plus-circle me-1"></i> Tambah Penjualan Baru 
                                        </a> 
                                    </div> 
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-light-hover:hover {
        background-color: #f8f9fa !important;
        transform: translateY(-2px);
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-action {
        transition: all 0.2s ease;
    }
    
    .btn-action:hover {
        transform: scale(1.1);
    }
    
    .sales-row:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transition: background-color 0.3s ease;
    }
    
    .date-group {
        border-left: 4px solid #0d6efd;
        padding-left: 1rem;
        margin-left: 0.5rem;
    }
    
    .avatar {
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .collapse .card-body {
        border-top: 1px solid rgba(0,0,0,0.125);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Card hover effects
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'transform 0.3s ease';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Button loading animation
    const actionButtons = document.querySelectorAll('.btn-action');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon) {
                const originalClass = icon.className;
                icon.className = 'fas fa-spinner fa-spin';
                setTimeout(() => {
                    if (document.body.contains(icon)) {
                        icon.className = originalClass;
                    }
                }, 1000);
            }
        });
    });
    
    // Row highlight on hover
    const salesRows = document.querySelectorAll('.sales-row');
    salesRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transition = 'background-color 0.3s ease';
            this.style.backgroundColor = 'rgba(13, 110, 253, 0.05)';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
    
    // Date group animation
    const dateGroups = document.querySelectorAll('.date-group');
    dateGroups.forEach((group, index) => {
        group.style.opacity = '0';
        group.style.transform = 'translateY(20px)';
        setTimeout(() => {
            group.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            group.style.opacity = '1';
            group.style.transform = 'translateY(0)';
        }, 100 * index);
    });
    
    // Auto-collapse filter after applying
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('start_date') || urlParams.has('end_date')) {
        const filterCollapse = document.getElementById('filterCollapse');
        if (filterCollapse) {
            // Keep it expanded if there are active filters, but add visual indicator
            filterCollapse.classList.add('show');
        }
    }
    
    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                e.preventDefault();
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir');
                return false;
            }
        });
    }
});
</script>
@endpush
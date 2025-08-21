@extends(auth()->user()->role == 'administrator' ? 'layouts.admin' : 'layouts.petugas')

@section('title', 'Detail Penjualan Petugas')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Detail Penjualan Petugas</h5>
                        <a href="{{ route('penjualan.laporan.petugas') }}" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
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

                    <!-- Petugas Info -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                                    {{ substr($petugas->name, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $petugas->name }}</h5>
                                    <div class="text-muted">{{ $petugas->email }}</div>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <div class="text-muted small">Total Transaksi</div>
                                                    <div class="h4 mb-0">{{ $detailPenjualan->unique('PenjualanID')->count() }}</div>
                                                </div>
                                                <div>
                                                    <i class="fas fa-shopping-cart text-primary fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <div class="text-muted small">Total Produk Terjual</div>
                                                    <div class="h4 mb-0">{{ $detailPenjualan->sum('JumlahProduk') }}</div>
                                                </div>
                                                <div>
                                                    <i class="fas fa-box text-success fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <div class="text-muted small">Total Pendapatan</div>
                                                    <div class="h4 mb-0">{{ number_format($totalPenjualan, 0, ',', '.') }}</div>
                                                </div>
                                                <div>
                                                    <span class="text-info fa-2x fw-bold">Rp</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Penjualan -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-history text-primary me-2"></i>
                                <h6 class="mb-0">Riwayat Penjualan</h6>
                            </div>

                            @if($detailPenjualan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Pelanggan</th>
                                            <th>Produk</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-end">Subtotal</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detailPenjualan as $detail)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($detail->TanggalPenjualan)->format('d/m/Y') }}</td>
                                            <td>{{ $detail->NamaPelanggan }}</td>
                                            <td>{{ $detail->NamaProduk }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border">{{ $detail->JumlahProduk }}</span>
                                            </td>
                                            <td class="text-end text-success fw-bold">
                                                Rp {{ number_format($detail->Subtotal, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('penjualan.show', $detail->PenjualanID) }}" class="btn btn-sm btn-info btn-action">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fas fa-box-open text-muted fa-3x mb-3"></i>
                                <h5 class="text-muted">Belum Ada Penjualan</h5>
                                <p class="text-muted mb-0">Petugas ini belum memiliki riwayat penjualan.</p>
                            </div>
                            @endif
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
    /* Enhanced Styling */
    :root {
        --transition-speed: 0.3s;
        --border-radius: 0.6rem;
        --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-hover: 0 6px 12px rgba(0,0,0,0.15);
    }
    
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
    }
    
    .card {
        border-radius: var(--border-radius);
        border: none;
        transition: all var(--transition-speed);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    
    .card:hover {
        box-shadow: var(--shadow-md);
    }
    
    .card-header {
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        font-weight: 500;
    }
    
    .btn {
        border-radius: 0.35rem;
        transition: all var(--transition-speed);
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }
    
    .table tbody tr {
        transition: all var(--transition-speed);
    }
    
    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.03em;
    }
    
    .table tbody tr {
        border-left: 3px solid transparent;
    }
    
    .table tbody tr:hover {
        border-left: 3px solid var(--bs-primary);
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
        border-radius: 50rem;
    }
    
    .btn-info, .btn-success, .btn-danger {
        color: white;
    }
    
    @media (max-width: 767.98px) {
        .table-responsive {
            max-height: 400px;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
        }
        th, td {
            padding: 0.6rem;
            font-size: 0.9rem;
        }
        .card-body {
            padding: 1rem;
        }
        .badge {
            font-size: 0.7rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto hide alerts
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => {
                alert.remove();
            }, 150);
        }, 3000);
    });
    
    // Add hover effects
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add loading animation for buttons
    const actionButtons = document.querySelectorAll('.btn-action');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            const originalClass = icon.className;
            
            if (icon) {
                // Save original class
                if (!icon.dataset.originalClass) {
                    icon.dataset.originalClass = originalClass;
                }
                
                // Change to spinner
                icon.className = 'fas fa-spinner fa-spin';
                
                // Reset after delay or on page unload
                setTimeout(() => {
                    if (document.body.contains(icon)) {
                        icon.className = icon.dataset.originalClass;
                    }
                }, 500);
            }
        });
    });
    
    // Row animation on page load
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 50 * index);
    });
});
</script>
@endpush
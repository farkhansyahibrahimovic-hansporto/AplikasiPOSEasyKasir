@extends('layouts.petugas')

@section('content')
<div class="container py-4">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shopping-cart text-primary me-2"></i>
                    <h5 class="mb-0">Daftar Penjualan</h5>
                </div>
                <div>
                    <a href="{{ route('penjualan.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Baru
                    </a>
                    <button id="hapusSemuaTampilan" class="btn btn-outline-danger btn-sm ms-1">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                    <button id="resetTampilan" class="btn btn-outline-secondary btn-sm ms-1">
                        <i class="fas fa-sync"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Card untuk Petugas -->
    <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid #0d6efd !important;">
        <div class="card-body">
            <div class="d-flex align-items-start">
                <div class="me-3">
                    <i class="fas fa-info-circle text-primary fa-2x"></i>
                </div>
                <div>
                    <h6 class="text-primary mb-2">
                        <i class="fas fa-user-tie me-1"></i> Informasi untuk Petugas
                    </h6>
                    <p class="mb-2 text-muted">
                        Sebagai <strong>Petugas</strong>, Anda memiliki akses untuk:
                    </p>
                    <ul class="mb-2 text-muted small">
                        <li><i class="fas fa-plus text-success me-1"></i> Menambah transaksi penjualan baru</li>
                        <li><i class="fas fa-eye text-info me-1"></i> Melihat detail transaksi</li>
                        <li><i class="fas fa-print text-secondary me-1"></i> Mencetak struk penjualan</li>
                        <li><i class="fas fa-eye-slash text-warning me-1"></i> Menyembunyikan tampilan (sementara)</li>
                    </ul>
                    <div class="alert alert-warning py-2 px-3 mb-2 small">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        <strong>Penting:</strong> Hanya <strong>Admin</strong> yang dapat mengelola dan menghapus data penjualan secara permanen.
                    </div>
                    <p class="mb-0 small text-muted">
                        <i class="fas fa-phone text-danger me-1"></i>
                        Jika ada masalah atau kesalahan data, silakan <strong>hubungi Admin</strong> segera.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Total Penjualan</div>
                        <div class="h4 mb-0">{{ $totalPenjualan }}</div>
                    </div>
                    <div>
                        <i class="fas fa-calendar-check text-primary opacity-50 fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Transaksi Terakhir</div>
                        <div class="h4 mb-0">{{ $transaksiHariIni }}</div>
                    </div>
                    <div>
                        <i class="fas fa-chart-line text-success opacity-50 fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">Total Pendapatan (Kotor)</div>
                        <div class="h4 mb-0">{{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    </div>
                    <div>
                        <span class="text-info opacity-50 fa-2x fw-bold">Rp</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer">
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
    </div>

    <!-- Main Content -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <!-- Sales Data Grouped by Date -->
            <div class="sales-data-container">
                @php
                    // Gunakan semua data tanpa batasan paginasi
                    $groupedPenjualan = $semuaPenjualan->groupBy(function($item) {
                        return Carbon\Carbon::parse($item->TanggalPenjualan)->format('Y-m-d');
                    });
                @endphp

                @forelse($groupedPenjualan as $date => $penjualanGroup)
                    <div class="date-group mb-4">
                        <div class="bg-light p-2 rounded mb-2 d-flex align-items-center">
                            <i class="fas fa-calendar-day text-primary me-2"></i>
                            <span class="fw-bold">{{ Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                            <span class="badge bg-primary rounded-pill ms-2">{{ $penjualanGroup->count() }}</span>
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
                                                    <a href="{{ route('penjualan.show', $penjualan->PenjualanID) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('penjualan.print', $penjualan->PenjualanID) }}" class="btn btn-sm btn-success" target="_blank" title="Cetak Struk">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-warning btn-hapus-tampilan" data-id="{{ $penjualan->PenjualanID }}" title="Sembunyikan dari Tampilan">
                                                        <i class="fas fa-eye-slash"></i>
                                                    </button>
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
                        <p class="text-muted mb-3">Saat ini belum ada transaksi penjualan yang tercatat dalam sistem.</p>
                        <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Penjualan Baru
                        </a>
                    </div>
                @endforelse
            </div>
            
            <!-- Empty State (Hidden by default) -->
            <div id="emptyStateContainer" class="text-center py-5 d-none">
                <i class="fas fa-eye-slash text-muted fa-3x mb-3"></i>
                <h5 class="text-muted">Tidak Ada Data Untuk Ditampilkan</h5>
                <p class="text-muted mb-3">Semua transaksi telah disembunyikan dari tampilan.</p>
                <button id="resetTampilanEmpty" class="btn btn-warning me-2">
                    <i class="fas fa-sync me-1"></i> Tampilkan Semua
                </button>
                <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus dari Tampilan -->
<div class="modal fade" id="hapusTampilanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">
            <i class="fas fa-eye-slash me-2"></i> Sembunyikan Transaksi
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-4">
        <i class="fas fa-eye-slash fa-3x text-warning mb-3"></i>
        <h5>Sembunyikan dari tampilan?</h5>
        <p>Apakah Anda yakin ingin menyembunyikan transaksi ini dari tampilan saat ini?</p>
        <p class="text-muted small mt-2"><em>Data tidak akan dihapus dari database, hanya disembunyikan dari tampilan.</em></p>
        <div class="alert alert-info small mt-3">
            <i class="fas fa-info-circle me-1"></i>
            <strong>Catatan:</strong> Untuk menghapus data secara permanen, hubungi Admin.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-warning" id="konfirmasiHapusTampilan">Sembunyikan</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Hapus Semua dari Tampilan -->
<div class="modal fade" id="hapusSemuaTampilanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">
            <i class="fas fa-eye-slash me-2"></i> Sembunyikan Semua
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-4">
        <i class="fas fa-eye-slash fa-3x text-warning mb-3"></i>
        <h5>Sembunyikan semua transaksi?</h5>
        <p>Apakah Anda yakin ingin menyembunyikan SEMUA transaksi dari tampilan saat ini?</p>
        <p class="text-muted small mt-2"><em>Data tidak akan dihapus dari database, hanya disembunyikan dari tampilan.</em></p>
        <div class="alert alert-info small mt-3">
            <i class="fas fa-info-circle me-1"></i>
            <strong>Catatan:</strong> Untuk menghapus data secara permanen, hubungi Admin.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-warning" id="konfirmasiHapusSemuaTampilan">Sembunyikan Semua</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('styles')
<style>
    /* Simplified CSS */
    .card {
        border-radius: 0.5rem;
        transition: all 0.2s;
    }
    
    .btn {
        border-radius: 0.25rem;
    }
    
    .sales-row {
        transition: all 0.2s;
    }
    
    .sales-row:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .date-group {
        background: white;
        border-radius: 0.5rem;
    }
    
    /* Info card styling */
    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }
    
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .btn-sm {
            padding: 0.25rem 0.5rem;
        }
        
        th, td {
            padding: 0.5rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const STORAGE_KEY = 'hiddenPenjualanIDs';
    const dateGroups = document.querySelectorAll('.date-group');
    const emptyStateContainer = document.getElementById('emptyStateContainer');
    
    // Initialize hidden IDs from localStorage
    let hiddenPenjualanIDs = [];
    try {
        const storedData = localStorage.getItem(STORAGE_KEY);
        if (storedData) {
            hiddenPenjualanIDs = JSON.parse(storedData);
        }
    } catch (e) {
        console.error("Error loading from localStorage:", e);
        localStorage.removeItem(STORAGE_KEY);
    }
    
    // Apply filters on page load
    applyHiddenRowsFilter();
    
    // Hide row button handler
    document.querySelectorAll('.btn-hapus-tampilan').forEach(button => {
        button.addEventListener('click', function() {
            const penjualanId = this.getAttribute('data-id');
            const modal = new bootstrap.Modal(document.getElementById('hapusTampilanModal'));
            document.getElementById('konfirmasiHapusTampilan').setAttribute('data-id', penjualanId);
            modal.show();
        });
    });
    
    // Confirm hide row
    document.getElementById('konfirmasiHapusTampilan').addEventListener('click', function() {
        const penjualanId = this.getAttribute('data-id');
        const row = document.querySelector(`tr[data-id="${penjualanId}"]`);
        
        if (row) {
            // Add ID to hidden list if not already there
            if (!hiddenPenjualanIDs.includes(penjualanId)) {
                hiddenPenjualanIDs.push(penjualanId);
                saveHiddenRowsToStorage();
            }
            
            // Hide with animation
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                showNotification('Transaksi berhasil disembunyikan dari tampilan', 'success');
                checkDateGroupsEmpty();
                checkAllDataEmpty();
            }, 300);
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('hapusTampilanModal')).hide();
        }
    });
    
    // Hide all button handler
    document.getElementById('hapusSemuaTampilan').addEventListener('click', function() {
        const rows = document.querySelectorAll('.sales-row');
        if (rows.length === 0) {
            showNotification('Tidak ada data untuk disembunyikan', 'info');
            return;
        }
        const modal = new bootstrap.Modal(document.getElementById('hapusSemuaTampilanModal'));
        modal.show();
    });
    
    // Confirm hide all rows
    document.getElementById('konfirmasiHapusSemuaTampilan').addEventListener('click', function() {
        const rows = document.querySelectorAll('.sales-row');
        
        if (rows.length > 0) {
            rows.forEach((row, index) => {
                const penjualanId = row.getAttribute('data-id');
                if (penjualanId && !hiddenPenjualanIDs.includes(penjualanId)) {
                    hiddenPenjualanIDs.push(penjualanId);
                }
                
                row.style.opacity = '0';
                setTimeout(() => {
                    row.remove();
                }, 300);
            });
            
            saveHiddenRowsToStorage();
            
            setTimeout(() => {
                showNotification('Semua transaksi berhasil disembunyikan dari tampilan', 'success');
                checkDateGroupsEmpty();
                showEmptyState();
            }, 300);
            
            bootstrap.Modal.getInstance(document.getElementById('hapusSemuaTampilanModal')).hide();
        }
    });
    
    // Reset buttons handler
    document.querySelectorAll('#resetTampilan, #resetTampilanEmpty').forEach(button => {
        button.addEventListener('click', function() {
            localStorage.removeItem(STORAGE_KEY);
            hiddenPenjualanIDs = [];
            showNotification('Tampilan berhasil direset, semua data ditampilkan kembali', 'info');
            setTimeout(() => {
                location.reload();
            }, 1000);
        });
    });
    
    // Save hidden rows to localStorage
    function saveHiddenRowsToStorage() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(hiddenPenjualanIDs));
        } catch (e) {
            console.error("Error saving to localStorage:", e);
        }
    }
    
    // Apply filters for hidden rows
    function applyHiddenRowsFilter() {
        if (hiddenPenjualanIDs.length === 0) return;
        
        hiddenPenjualanIDs.forEach(id => {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) {
                row.remove();
            }
        });
        
        checkDateGroupsEmpty();
        checkAllDataEmpty();
    }
    
    // Check if date groups are empty
    function checkDateGroupsEmpty() {
        dateGroups.forEach(group => {
            const rows = group.querySelectorAll('.sales-row');
            if (rows.length === 0) {
                group.remove();
            }
        });
    }
    
    // Check if all data is empty
    function checkAllDataEmpty() {
        const remainingRows = document.querySelectorAll('.sales-row');
        if (remainingRows.length === 0) {
            showEmptyState();
        }
    }
    
    // Show empty state
    function showEmptyState() {
        const salesDataContainer = document.querySelector('.sales-data-container');
        if (salesDataContainer) {
            salesDataContainer.style.display = 'none';
        }
        emptyStateContainer.classList.remove('d-none');
    }
    
    // Show notification
    function showNotification(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer');
        
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.role = 'alert';
        
        let icon = 'info-circle';
        if (type === 'success') icon = 'check-circle';
        if (type === 'danger') icon = 'exclamation-circle';
        if (type === 'warning') icon = 'exclamation-triangle';
        
        alert.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${icon} me-2"></i>
                <div>${message}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        alertContainer.appendChild(alert);
        
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => {
                alert.remove();
            }, 150);
        }, 4000);
    }
    
    // Auto hide alerts
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => {
                alert.remove();
            }, 150);
        }, 3000);
    });
});
</script>
@endsection
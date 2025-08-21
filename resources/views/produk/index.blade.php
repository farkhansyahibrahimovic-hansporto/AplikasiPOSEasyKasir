@extends(auth()->user()->role == 'administrator' ? 'layouts.admin' : 'layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <div class="mb-3 mb-md-0">
            <h4 class="mb-0">
                <i class="fas fa-boxes me-2"></i>Data Produk
            </h4>
            <p class="text-muted small mb-0">Kelola inventori produk</p>
        </div>
        <a href="{{ route('produk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Produk
        </a>
    </div>

    <!-- Tabel Produk -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">ID</th>
                            <th>Nama Produk</th>
                            <th width="15%">Harga</th>
                            <th width="10%">Stok</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk as $p)
                        <tr>
                            <td>PRD{{ str_pad($p->ProdukID, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $p->NamaProduk }}</td>
                            <td>Rp {{ number_format($p->Harga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge 
                                    {{ $p->Stok <= 5 ? 'bg-danger' : ($p->Stok <= 10 ? 'bg-warning' : 'bg-success') }}">
                                    {{ $p->Stok }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('produk.show', $p->ProdukID) }}" 
                                       class="btn btn-sm btn-outline-info"
                                       data-bs-toggle="tooltip" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('produk.edit', $p->ProdukID) }}" 
                                       class="btn btn-sm btn-outline-warning"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('produk.destroy', $p->ProdukID) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Hapus produk ini?')"
                                                data-bs-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
    }
    .table th {
        white-space: nowrap;
    }
    .badge {
        font-weight: 500;
        min-width: 30px;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    @media (max-width: 768px) {
        .d-flex {
            flex-wrap: wrap;
        }
        .table-responsive {
            font-size: 0.85rem;
        }
    }
</style>

<script>
    // Inisialisasi tooltip
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endsection
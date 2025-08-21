@extends(auth()->user()->role == 'administrator' ? 'layouts.admin' : 'layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">
                <i class="fas fa-box me-2"></i>Detail Produk
            </h4>
            <p class="text-muted small mb-0">Informasi lengkap produk</p>
        </div>
        <div class="mt-2 mt-md-0">
            <a href="{{ route('produk.edit', $produk->ProdukID) }}" class="btn btn-sm btn-warning me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <button onclick="window.history.back()" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </button>
        </div>
    </div>

    <!-- Detail Produk -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <!-- Nama Produk -->
                <dt class="col-sm-4 text-muted">Nama Produk</dt>
                <dd class="col-sm-8 mb-3">{{ $produk->NamaProduk }}</dd>
                
                <!-- Harga -->
                <dt class="col-sm-4 text-muted">Harga</dt>
                <dd class="col-sm-8 mb-3">Rp {{ number_format($produk->Harga, 0, ',', '.') }}</dd>
                
                <!-- Stok -->
                <dt class="col-sm-4 text-muted">Stok</dt>
                <dd class="col-sm-8 mb-3">
                    <span class="badge {{ $produk->Stok <= 5 ? 'bg-danger' : ($produk->Stok <= 10 ? 'bg-warning' : 'bg-success') }}">
                        {{ $produk->Stok }} unit
                    </span>
                </dd>
                
                <!-- Tanggal Dibuat -->
                <dt class="col-sm-4 text-muted">Dibuat</dt>
                <dd class="col-sm-8 mb-3">
                    <i class="far fa-calendar-alt me-1 text-muted"></i>
                    {{ $produk->created_at->format('d/m/Y H:i') }}
                </dd>
                
                <!-- Terakhir Diupdate -->
                <dt class="col-sm-4 text-muted">Diperbarui</dt>
                <dd class="col-sm-8">
                    <i class="far fa-calendar-alt me-1 text-muted"></i>
                    {{ $produk->updated_at->format('d/m/Y H:i') }}
                </dd>
            </dl>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
    }
    dt {
        font-weight: 500;
    }
    dd {
        margin-bottom: 1rem;
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }
        dt, dd {
            padding: 0.25rem 0;
        }
    }
</style>
@endsection
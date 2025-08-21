@extends(auth()->user()->role == 'administrator' ? 'layouts.admin' : 'layouts.petugas')

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <h1 class="mb-0">Tambah Produk</h1>
        <button onclick="window.history.back()" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('produk.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="NamaProduk" class="form-label fw-semibold">Nama Produk</label>
                    <input type="text" class="form-control @error('NamaProduk') is-invalid @enderror" 
                           id="NamaProduk" name="NamaProduk" 
                           value="{{ old('NamaProduk') }}" required>
                    @error('NamaProduk')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="Harga" class="form-label fw-semibold">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">Rp</span>
                        <input type="number" class="form-control @error('Harga') is-invalid @enderror" 
                               id="Harga" name="Harga" 
                               value="{{ old('Harga') }}" step="100" min="0" required>
                        @error('Harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="Stok" class="form-label fw-semibold">Stok</label>
                    <input type="number" class="form-control @error('Stok') is-invalid @enderror" 
                           id="Stok" name="Stok" 
                           value="{{ old('Stok', 0) }}" min="0" required>
                    @error('Stok')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary py-2">
                        <i class="fas fa-save me-1"></i> Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
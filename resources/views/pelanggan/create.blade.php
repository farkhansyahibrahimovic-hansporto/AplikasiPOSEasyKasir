@extends('layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">
                <i class="fas fa-user-plus me-2"></i>Tambah Pelanggan Baru
            </h4>
            <p class="text-muted small mb-0">Isi form berikut untuk menambahkan pelanggan baru</p>
        </div>
        <button onclick="window.history.back()" class="btn btn-sm btn-secondary mt-2 mt-md-0">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </button>
    </div>

    <!-- Form Tambah -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-3">
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                
                <!-- Nama Pelanggan -->
                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('NamaPelanggan') is-invalid @enderror" 
                           name="NamaPelanggan" 
                           value="{{ old('NamaPelanggan') }}"
                           required>
                    @error('NamaPelanggan')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>
                
                <!-- Alamat -->
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control @error('Alamat') is-invalid @enderror" 
                              name="Alamat" rows="3">{{ old('Alamat') }}</textarea>
                    @error('Alamat')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>
                
                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="tel" class="form-control @error('NomorTelepon') is-invalid @enderror" 
                           name="NomorTelepon" 
                           value="{{ old('NomorTelepon') }}"
                           pattern="[0-9]*">
                    <small class="text-muted">Contoh: 081234567890 (hanya angka)</small>
                    @error('NomorTelepon')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary py-2">
                        <i class="fas fa-save me-1"></i> Simpan Pelanggan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
    }
    .form-label {
        font-weight: 500;
    }
    .text-danger {
        color: #dc3545;
    }
    .invalid-feedback {
        font-size: 0.85rem;
    }
    @media (max-width: 768px) {
        .form-control, .form-select {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
        }
        .btn {
            padding: 0.5rem 1rem;
        }
    }
</style>
@endsection
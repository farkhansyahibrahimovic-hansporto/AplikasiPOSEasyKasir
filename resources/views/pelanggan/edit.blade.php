@extends('layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">
                <i class="fas fa-user-edit me-2"></i>Edit Pelanggan
            </h4>
            <p class="text-muted small mb-0">Kosongkan field jika tidak ingin mengubah data</p>
        </div>
        <button onclick="window.history.back()" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </button>
    </div>

    <!-- Form Edit -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-3">
            <!-- ID Display -->
            <div class="mb-3 p-2 bg-light rounded d-flex justify-content-between align-items-center">
                <span class="text-muted">ID Pelanggan:</span>
                <span class="fw-bold">{{ $pelanggan->PelangganID }}</span>
            </div>
            
            <form action="{{ route('pelanggan.update', $pelanggan->PelangganID) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Nama Pelanggan -->
                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control @error('NamaPelanggan') is-invalid @enderror" 
                           name="NamaPelanggan" 
                           value="{{ old('NamaPelanggan', $pelanggan->NamaPelanggan) }}"
                           placeholder="Biarkan kosong untuk tidak mengubah">
                    @error('NamaPelanggan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <!-- Alamat -->
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control @error('Alamat') is-invalid @enderror" 
                              name="Alamat" rows="2"
                              placeholder="Biarkan kosong untuk tidak mengubah">{{ old('Alamat', $pelanggan->Alamat) }}</textarea>
                    @error('Alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <!-- Nomor Telepon -->
                <div class="mb-4">
                    <label class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control @error('NomorTelepon') is-invalid @enderror" 
                           name="NomorTelepon" 
                           value="{{ old('NomorTelepon', $pelanggan->NomorTelepon) }}"
                           placeholder="Biarkan kosong untuk tidak mengubah">
                    @error('NomorTelepon')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
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
    .bg-light {
        background-color: #f8f9fa !important;
    }
    .form-control {
        border: 1px solid #dee2e6;
    }
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }
        .d-flex {
            flex-direction: column;
            align-items: flex-start;
        }
        .btn-secondary {
            margin-top: 0.5rem;
        }
    }
</style>
@endsection
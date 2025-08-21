@extends('layouts.petugas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800"><i class="fas fa-users me-2"></i> Data Pelanggan</h1>
            <p class="text-muted small mb-0">Manajemen data pelanggan</p>
        </div>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Pelanggan
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Nomor Telepon</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggan as $p)
                        <tr>
                            <td class="fw-bold">{{ $p->PelangganID }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        {{ substr($p->NamaPelanggan, 0, 1) }}
                                    </div>
                                    <div>
                                        {{ $p->NamaPelanggan }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($p->Alamat)
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                {{ $p->Alamat }}
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($p->NomorTelepon)
                                <i class="fas fa-phone-alt text-success me-1"></i>
                                {{ $p->NomorTelepon }}
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('pelanggan.show', $p->PelangganID) }}" 
                                       class="btn btn-sm btn-info mx-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pelanggan.edit', $p->PelangganID) }}" 
                                       class="btn btn-sm btn-warning mx-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger mx-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#hapusPelangganModal"
                                            data-url="{{ route('pelanggan.destroy', $p->PelangganID) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
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

<!-- Modal Konfirmasi Hapus Pelanggan -->
<div class="modal fade" id="hapusPelangganModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="fas fa-user-slash me-2"></i> Hapus Pelanggan
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-4">
        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
        <h5>Hapus pelanggan secara permanen?</h5>
        <p>Apakah Anda yakin ingin menghapus data pelanggan ini beserta semua transaksinya dari database?</p>
        <p class="text-danger small mt-2"><strong>PERHATIAN: Data yang dihapus tidak dapat dikembalikan!</strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <form id="hapusPelangganForm" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash me-1"></i> Hapus Permanen
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
    .table th {
        white-space: nowrap;
    }
    .table td {
        vertical-align: middle;
    }
    .card {
        border: none;
        border-radius: 0.5rem;
    }
    .thead-light {
        background-color: #f8f9fa;
    }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Tangkap semua tombol hapus
    const deleteButtons = document.querySelectorAll('[data-bs-target="#hapusPelangganModal"]');
    
    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        // Ambil URL dari atribut data-url
        const url = this.getAttribute('data-url');
        // Set action form
        document.getElementById('hapusPelangganForm').action = url;
      });
    });
  });
</script>
@endsection
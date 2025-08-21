@extends('dashboard.dashboardadmin')

@section('content')
<div class="container-fluid px-0 px-md-3">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <!-- Information Box Added Here -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body bg-light-info">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-info-circle fa-2x text-info"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Informasi Detail Petugas</h5>
                            <p class="card-text mb-0">
                                Halaman ini menampilkan informasi lengkap tentang petugas. Anda dapat melihat data pribadi, 
                                mengedit informasi, atau menghapus akun petugas dari sistem. Jika ada kesalahan anda juga dapat menegur
                                petugas melalui email mereka.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-user-circle mr-2"></i>Detail Petugas
                    </h4>
                    <button onclick="window.history.back()" class="btn btn-light btn-sm" title="Kembali">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </button>
                </div>

                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item py-3 px-3 px-md-4">
                            <div class="row align-items-center">
                                <div class="col-5 col-md-4 font-weight-bold text-muted">Nama Lengkap</div>
                                <div class="col-7 col-md-8">
                                    <span class="font-weight-semibold">{{ $petugas->name }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item py-3 px-3 px-md-4">
                            <div class="row align-items-center">
                                <div class="col-5 col-md-4 font-weight-bold text-muted">Email</div>
                                <div class="col-7 col-md-8 text-truncate" title="{{ $petugas->email }}">
                                    <a href="mailto:{{ $petugas->email }}" class="text-decoration-none">
                                        {{ $petugas->email }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item py-3 px-3 px-md-4">
                            <div class="row align-items-center">
                                <div class="col-5 col-md-4 font-weight-bold text-muted">Role</div>
                                <div class="col-7 col-md-8">
                                    <span class="badge bg-primary text-white py-1 px-2">
                                        {{ ucfirst($petugas->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item py-3 px-3 px-md-4">
                            <div class="row align-items-center">
                                <div class="col-5 col-md-4 font-weight-bold text-muted">Tanggal Daftar</div>
                                <div class="col-7 col-md-8">
                                    <span title="{{ $petugas->created_at->format('d/m/Y H:i:s') }}">
                                        {{ $petugas->created_at->translatedFormat('l, d F Y H:i') }}
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        ({{ $petugas->created_at->diffForHumans() }})
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center p-3 p-md-4 border-top">
                        <small class="text-muted mb-2 mb-sm-0">
                            ID: {{ $petugas->id }} • Terakhir diupdate: {{ $petugas->updated_at->diffForHumans() }}
                        </small>
                        <div class="d-flex flex-wrap justify-content-end">
                            <a href="{{ route('petugas.edit', $petugas->id) }}" class="btn btn-primary btn-sm mx-1 mb-2">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('petugas.destroy', $petugas->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mx-1 mb-2" onclick="return confirm('Hapus petugas ini? Tindakan tidak dapat dibatalkan.')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                            <a href="{{ route('petugas.index') }}" class="btn btn-secondary btn-sm mx-1 mb-2">
                                <i class="fas fa-list mr-1"></i> Daftar Petugas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Keyboard shortcut for back button (Alt + Arrow Left)
    document.addEventListener('keydown', function(event) {
        if (event.altKey && event.keyCode === 37) { // Alt + Left Arrow
            window.history.back();
        }
    });
</script>
@endsection
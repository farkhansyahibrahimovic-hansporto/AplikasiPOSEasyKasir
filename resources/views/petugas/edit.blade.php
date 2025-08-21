@extends('dashboard.dashboardadmin')

@section('content')
<div class="container-fluid px-2 px-md-4 py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-6">
            <!-- Information Box Added Here -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body bg-light-primary">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-info-circle fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Edit Data Petugas</h5>
                            <p class="card-text mb-0">
                                Halaman ini memungkinkan Anda untuk memperbarui informasi petugas. 
                                Perhatikan bahwa perubahan data mungkin memerlukan verifikasi ulang.
                                Silahkan konfirmasi kepada petugas terlebih dahulu untuk meminta data
                                lama mereka guna perubahan yang aman serta terstruktur.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-edit mr-2"></i>
                        <h5 class="mb-0">Edit Data Petugas</h5>
                    </div>
                </div>

                <div class="card-body px-3 px-md-4 py-4">
                    <div class="d-flex justify-content-start mb-4">
                        <button onclick="window.history.back()" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </button>
                    </div>

                    <form method="POST" action="{{ route('petugas.update', $petugas->id) }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $petugas->name) }}" required
                                       placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $petugas->email) }}" required
                                       placeholder="contoh@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password"
                                       placeholder="Kosongkan jika tidak ingin mengubah">
                                <button class="btn btn-outline-secondary toggle-password" type="button"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Tampilkan Password">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>Minimal 8 karakter (isi hanya jika ingin mengubah password)
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold">Konfirmasi Password</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control" 
                                       id="password-confirm" name="password_confirmation"
                                       placeholder="Ketik ulang password baru">
                                <button class="btn btn-outline-secondary toggle-password" type="button"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Tampilkan Password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-grid d-md-flex justify-content-md-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Toggle password visibility
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('i');
            
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
            
            // Update tooltip text
            const tooltip = bootstrap.Tooltip.getInstance(button);
            if (tooltip) {
                tooltip.setContent({'.tooltip-inner': input.type === 'password' ? 'Tampilkan Password' : 'Sembunyikan Password'});
            }
        });
    });

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Keyboard shortcut for back (Alt + Left Arrow)
    document.addEventListener('keydown', function(e) {
        if (e.altKey && e.key === 'ArrowLeft') {
            window.history.back();
        }
    });
});
</script>
@endsection
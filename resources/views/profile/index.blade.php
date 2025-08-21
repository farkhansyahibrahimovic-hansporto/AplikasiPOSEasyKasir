@extends(auth()->user()->role == 'administrator' ? 'layouts.admin' : 'layouts.petugas')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <h4 class="mb-2">
            <i class="fas {{ auth()->user()->role === 'administrator' ? 'fa-user-shield' : 'fa-user-tie' }} me-2"></i>Profil Saya
        </h4>
        <p class="text-muted small mb-0">Kelola informasi akun Anda dan pantau aktivitas</p>
    </div>

    <!-- Notification Boxes -->
    <div class="row mb-4">
        <!-- Common Notification Box (for all users) -->
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="info-box bg-light p-4 rounded h-100 border-start border-4 border-info">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3 text-info">
                        <i class="fas fa-info-circle fs-3"></i>
                    </div>
                    <div>
                        <h5 class="text-info mb-2">Informasi Keamanan</h5>
                        <ul class="mb-0 ps-3">
                            <li>Jangan bagikan kredensial login Anda</li>
                            <li>Selalu logout setelah menggunakan sistem</li>
                            <li>Hubungi admin untuk perubahan data akun</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conditional Notification Box (based on role) -->
        @if(auth()->user()->role === 'administrator')
        <div class="col-md-6">
            <div class="info-box bg-light p-4 rounded h-100 border-start border-4 border-primary">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3 text-primary">
                        <i class="fas fa-user-shield fs-3"></i>
                    </div>
                    <div>
                        <h5 class="text-primary mb-2">Informasi Khusus Admin</h5>
                        <ul class="mb-0 ps-3">
                            <li>Anda memiliki akses penuh ke sistem</li>
                            <li>Bertanggung jawab atas manajemen pengguna</li>
                            <li>Sama seperti petugas, anda tidak dapat merubah sandi anda sendiri</li>
                            <li>Hubungi tim IT anda untuk perubahan data atau anda bisa mengkonfigurasinya sendiri pada server database aplikasi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-md-6">
            <div class="info-box bg-light p-4 rounded h-100 border-start border-4 border-success">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3 text-success">
                        <i class="fas fa-user-tie fs-3"></i>
                    </div>
                    <div>
                        <h5 class="text-success mb-2">Informasi Khusus Petugas</h5>
                        <ul class="mb-0 ps-3">
                            <li>Gunakan sistem sesuai prosedur yang berlaku</li>
                            <li>Laporkan masalah teknis ke admin</li>
                            <li>Verifikasi data sebelum diproses</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Profile Content -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <!-- Profile Header -->
                <div class="card-header text-center">
                    <div class="avatar-container mb-3">
                        <div class="avatar">
                            <i class="fas {{ auth()->user()->role === 'administrator' ? 'fa-user-shield' : 'fa-user-tie' }}"></i>
                        </div>
                    </div>
                    <h3 class="mb-2">{{ auth()->user()->name }}</h3>
                    <span class="badge {{ auth()->user()->role === 'administrator' ? 'bg-primary' : 'bg-success' }}">
                        <i class="fas {{ auth()->user()->role === 'administrator' ? 'fa-crown' : 'fa-clipboard-list' }} me-2"></i>
                        {{ auth()->user()->role === 'administrator' ? 'Administrator' : 'Petugas' }}
                    </span>
                </div>

                <!-- Profile Information -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <p class="form-control-plaintext">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-user-tag me-2"></i>Role
                            </label>
                            <p class="form-control-plaintext text-capitalize">{{ auth()->user()->role }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-calendar-alt me-2"></i>Bergabung Sejak
                            </label>
                            <p class="form-control-plaintext">{{ auth()->user()->created_at->translatedFormat('d F Y') }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                <i class="fas fa-clock me-2"></i>Terakhir Update
                            </label>
                            <p class="form-control-plaintext">{{ auth()->user()->updated_at->translatedFormat('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-container {
    margin-bottom: 1rem;
}

.avatar {
    width: 80px;
    height: 80px;
    background-color: #f8f9fa;
    border: 2px solid #dee2e6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 2rem;
    color: #6c757d;
}

.form-control-plaintext {
    font-weight: 500;
    color: #212529 !important;
    margin-bottom: 0;
}

.form-label {
    font-weight: 600;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

/* Notification Boxes Styles */
.info-box {
    background-color: #f8fafc;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    transition: transform 0.2s;
}

.info-box:hover {
    transform: translateY(-2px);
}

.info-box h5 {
    font-size: 1.05rem;
    font-weight: 600;
}

.info-box ul {
    padding-left: 1rem;
}

.info-box ul li {
    margin-bottom: 0.4rem;
    line-height: 1.5;
}

.border-info {
    border-color: #0dcaf0 !important;
}

.border-primary {
    border-color: #0d6efd !important;
}

.border-success {
    border-color: #198754 !important;
}

@media (max-width: 768px) {
    .avatar {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .info-box {
        padding: 1.25rem;
    }
    
    .info-box .fs-3 {
        font-size: 1.75rem !important;
    }
}
</style>
@endsection
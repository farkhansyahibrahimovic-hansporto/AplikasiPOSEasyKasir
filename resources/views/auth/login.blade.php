@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-xl-4 col-lg-5 col-md-6">
            <div class="card login-card">
                <!-- Card Header with 3D Logo -->
                <div class="card-header login-header">
                    <div class="logo-3d-container">
                        <div class="logo-3d">
                            <div class="logo-front">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                                    <path d="M4 6h16v2H4zm2-4h12v2H6zm14 8H4c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2zm0 10H4v-8h16v8zm-10-7h6v2h-6z"/>
                                </svg>
                            </div>
                            <div class="logo-back">EasyKasir</div>
                        </div>
                    </div>
                    <h1>EasyKasir</h1>
                    <p class="subtitle">Point of Sale System</p>
                </div>

                <!-- Login Form -->
                <div class="card-body login-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-with-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2" class="input-icon">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                       class="@error('email') is-invalid @enderror" required autofocus
                                       placeholder="Enter your email">
                            </div>
                            @error('email')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-with-icon password-container">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2" class="input-icon">
                                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/>
                                </svg>
                                <input type="password" id="password" name="password" required
                                       class="@error('password') is-invalid @enderror" 
                                       placeholder="Enter your password">
                                <div class="password-toggle" onclick="togglePasswordVisibility()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2" class="show-password">
                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2" class="hide-password" style="display: none;">
                                        <path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('password')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="login-button">Login</button>

                        <!-- Register Link -->
                        <div class="register-link">
                            Belum punya akun? <a href="#" onclick="openRegistrationModal(event)">Register</a>
                        </div>
                        
                        <!-- Copyright -->
                        <div class="copyright">
                            &copy; {{ date('Y') }} EasyKasir. All Rights Reserved.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registration Requirements Modal -->
<div id="registrationModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
            <h2>Proses Pendaftaran Petugas Kasir</h2>
            <button class="modal-close" onclick="closeRegistrationModal()">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="process-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h4>Kirim Email Pendaftaran</h4>
                        <p>Kirim email ke salah satu admin dengan mencantumkan dokumen persyaratan yang diperlukan</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h4>Verifikasi Admin</h4>
                        <p>Admin akan memverifikasi dokumen dan persyaratan yang Anda kirimkan</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h4>Penerimaan Email Balasan</h4>
                        <p>Jika diterima, admin akan mengirim email balasan berisi formulir pendataan diri yang harus diisi</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h4>Isi Formulir Pendataan</h4>
                        <p>Isi formulir dengan lengkap yang mencakup: nama lengkap, email, dan password yang ingin digunakan</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h4>Balas Email Admin</h4>
                        <p>Setelah mengisi formulir, balas email admin untuk konfirmasi akhir</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">6</div>
                    <div class="step-content">
                        <h4>Aktivasi Akun</h4>
                        <p>Admin akan membuatkan akun Anda dan mengirimkan konfirmasi ketika akun sudah aktif</p>
                    </div>
                </div>
            </div>
            
            <div class="requirements-section">
                <h3 class="section-title">Persyaratan Dokumen</h3>
                
                <div class="requirement-item">
                    <div class="requirement-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 2 2h8c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                    </div>
                    <div class="requirement-text">
                        <h4>Dokumen Wajib</h4>
                        <p>CV, fotocopy KTP, ijazah terakhir, foto 3x4, dan surat keterangan sehat</p>
                    </div>
                </div>
                
                <div class="requirement-item">
                    <div class="requirement-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </div>
                    <div class="requirement-text">
                        <h4>Format Email</h4>
                        <p>Subject email: "Pendaftaran Petugas Kasir - [Nama Lengkap]". Lampirkan semua dokumen dalam format PDF</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <div class="contact-info">
                <p class="contact-text">Untuk pendaftaran, silakan hubungi salah satu admin melalui email:</p>
                <div class="admin-list" id="adminList">
                    <!-- Admin emails will be populated here -->
                    <div class="admin-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <a href="mailto:admin1@easykasir.com" class="admin-email">admin1@easykasir.com</a>
                    </div>
                    <div class="admin-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <a href="mailto:admin2@easykasir.com" class="admin-email">admin2@easykasir.com</a>
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-primary" onclick="closeRegistrationModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #4A90E2;
        --secondary-color: #50E3C2;
        --dark-color: #2C3E50;
        --light-color: #F5F7FA;
        --error-color: #E74C3C;
        --success-color: #27AE60;
    }

    body {
        background-color: var(--light-color);
        background-image: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-container {
        padding: 20px;
    }

    .login-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .login-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        text-align: center;
        padding: 30px 20px;
        border-bottom: none;
    }

    .login-header h1 {
        font-weight: 700;
        margin: 15px 0 5px;
        font-size: 28px;
    }

    .login-header .subtitle {
        opacity: 0.9;
        font-size: 14px;
        margin: 0;
    }

    .logo-3d-container {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

    .logo-3d {
        width: 80px;
        height: 80px;
        position: relative;
        perspective: 1000px;
    }

    .logo-front, .logo-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: transform 0.6s;
    }

    .logo-front {
        background: rgba(255, 255, 255, 0.2);
        transform: rotateY(0deg);
    }

    .logo-front svg {
        width: 40px;
        height: 40px;
    }

    .logo-back {
        color: var(--primary-color);
        background: white;
        font-weight: bold;
        transform: rotateY(180deg);
        font-size: 12px;
        text-align: center;
        padding: 10px;
    }

    .logo-3d:hover .logo-front {
        transform: rotateY(-180deg);
    }

    .logo-3d:hover .logo-back {
        transform: rotateY(0deg);
    }

    .login-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--dark-color);
        font-weight: 500;
    }

    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        width: 20px;
        height: 20px;
        z-index: 2;
    }

    .input-with-icon input {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
        position: relative;
        background-color: transparent;
    }

    .input-with-icon input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
        outline: none;
    }

    .password-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 15px;
        cursor: pointer;
        z-index: 2;
    }

    .password-toggle svg {
        width: 22px;
        height: 22px;
    }

    .login-button {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .login-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
    }

    .register-link {
        text-align: center;
        margin-top: 20px;
        color: #666;
        font-size: 14px;
    }

    .register-link a {
        color: var(--primary-color);
        font-weight: 500;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    .copyright {
        text-align: center;
        margin-top: 20px;
        font-size: 12px;
        color: #888;
    }

    .error-message {
        color: var(--error-color);
        font-size: 13px;
        margin-top: 5px;
    }

    .is-invalid {
        border-color: var(--error-color) !important;
    }

    /* Modal Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(5px);
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .modal-overlay.active {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-container {
        background: white;
        border-radius: 20px;
        max-width: 600px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        animation: slideUp 0.4s ease;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 20px 20px 0 0;
        position: relative;
        text-align: center;
    }

    .modal-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }

    .modal-icon svg {
        width: 30px;
        height: 30px;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 25px;
        background: none;
        border: none;
        color: white;
        font-size: 30px;
        cursor: pointer;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s;
    }

    .modal-close:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .modal-body {
        padding: 30px;
    }

    /* Process Steps Styles */
    .process-steps {
        margin-bottom: 30px;
    }

    .step {
        display: flex;
        margin-bottom: 20px;
        position: relative;
        padding-left: 40px;
    }

    .step:not(:last-child):after {
        content: '';
        position: absolute;
        left: 19px;
        top: 30px;
        bottom: -20px;
        width: 2px;
        background: #e0e6ff;
    }

    .step-number {
        width: 30px;
        height: 30px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 15px;
        position: absolute;
        left: 0;
        z-index: 1;
    }

    .step-content {
        flex: 1;
    }

    .step-content h4 {
        margin: 0 0 5px 0;
        color: var(--dark-color);
        font-size: 16px;
    }

    .step-content p {
        margin: 0;
        color: #666;
        font-size: 14px;
        line-height: 1.5;
    }

    .section-title {
        color: var(--dark-color);
        font-size: 18px;
        margin: 25px 0 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    .requirements-section {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .requirement-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
        padding: 20px;
        background: #f8f9ff;
        border-radius: 12px;
        border-left: 4px solid var(--primary-color);
        transition: transform 0.2s ease;
    }

    .requirement-item:hover {
        transform: translateX(5px);
    }

    .requirement-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        box-shadow: 0 2px 8px rgba(74, 144, 226, 0.2);
    }

    .requirement-icon svg {
        width: 20px;
        height: 20px;
    }

    .requirement-text h4 {
        margin: 0 0 8px 0;
        color: var(--dark-color);
        font-weight: 600;
        font-size: 16px;
    }

    .requirement-text p {
        margin: 0;
        color: #666;
        font-size: 14px;
        line-height: 1.5;
    }

    .modal-footer {
        padding: 25px 30px 30px;
        border-top: 1px solid #eee;
    }

    .contact-info {
        text-align: center;
        margin-bottom: 20px;
    }

    .contact-text {
        color: #666;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .admin-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }

    .admin-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 15px;
        background: #f8f9ff;
        border-radius: 8px;
        border: 1px solid #e0e6ff;
    }

    .admin-item svg {
        width: 18px;
        height: 18px;
    }

    .admin-email {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        font-size: 16px;
    }

    .admin-email:hover {
        text-decoration: underline;
    }

    .modal-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-primary, .btn-secondary {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
    }

    .btn-secondary {
        background: #f8f9fa;
        color: #666;
        border: 1px solid #ddd;
    }

    .btn-secondary:hover {
        background: #e9ecef;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modal-container {
            margin: 10px;
            border-radius: 15px;
        }
        
        .modal-header {
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }
        
        .modal-header h2 {
            font-size: 20px;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .requirement-item {
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .modal-actions {
            flex-direction: column;
        }
        
        .btn-primary, .btn-secondary {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .login-card {
            border-radius: 10px;
        }
        
        .login-header {
            padding: 25px 15px;
        }
        
        .login-body {
            padding: 20px;
        }
    }
</style>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const showPasswordIcon = document.querySelector('.show-password');
        const hidePasswordIcon = document.querySelector('.hide-password');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showPasswordIcon.style.display = 'none';
            hidePasswordIcon.style.display = 'block';
        } else {
            passwordInput.type = 'password';
            showPasswordIcon.style.display = 'block';
            hidePasswordIcon.style.display = 'none';
        }
    }

    function openRegistrationModal(event) {
        event.preventDefault();
        loadAdminEmails();
        const modal = document.getElementById('registrationModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function loadAdminEmails() {
        // Fetch admin emails from backend
        fetch('/api/admin-emails')
            .then(response => response.json())
            .then(data => {
                const adminList = document.getElementById('adminList');
                adminList.innerHTML = '';
                
                if (data.admins && data.admins.length > 0) {
                    data.admins.forEach(admin => {
                        const adminItem = document.createElement('div');
                        adminItem.className = 'admin-item';
                        adminItem.innerHTML = `
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <a href="mailto:${admin.email}" class="admin-email">${admin.email}</a>
                        `;
                        adminList.appendChild(adminItem);
                    });
                } else {
                    // Fallback if no admins found
                    const adminItem = document.createElement('div');
                    adminItem.className = 'admin-item';
                    adminItem.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <a href="mailto:admin@easykasir.com" class="admin-email">admin@easykasir.com</a>
                    `;
                    adminList.appendChild(adminItem);
                }
            })
            .catch(error => {
                console.error('Error loading admin emails:', error);
                // Fallback on error
                const adminList = document.getElementById('adminList');
                adminList.innerHTML = `
                    <div class="admin-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4A90E2">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                        <a href="mailto:admin@easykasir.com" class="admin-email">admin@easykasir.com</a>
                    </div>
                `;
            });
    }

    function closeRegistrationModal() {
        const modal = document.getElementById('registrationModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('registrationModal');
        if (event.target === modal) {
            closeRegistrationModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeRegistrationModal();
        }
    });
</script>
@endsection
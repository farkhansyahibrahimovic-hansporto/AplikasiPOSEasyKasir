@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Hero Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white rounded-3 overflow-hidden">
                <div class="card-body p-4 p-lg-5 position-relative">
                    <!-- Animated Blur Circles -->
                    <div class="position-absolute top-0 end-0">
                        <div class="blur-circle bg-white bg-opacity-10" style="width: 150px; height: 150px; right: -50px; top: -50px;"></div>
                        <div class="blur-circle bg-white bg-opacity-5" style="width: 200px; height: 200px; right: -100px; top: 100px;"></div>
                    </div>
                    
                    <div class="row align-items-center position-relative">
                        <div class="col-lg-7 mb-4 mb-lg-0">
                            <h1 class="fw-bold mb-3 display-5">Dashboard Admin</h1>
                            <p class="lead mb-4 fs-4">Selamat datang di sistem pengelolaan inventori modern</p>
                            <div class="d-flex flex-wrap gap-3">
                                <a href="{{ route('produk.index') }}" class="btn btn-light px-4 py-2 rounded-pill shadow-sm hover-scale">
                                    <i class="fas fa-boxes me-2"></i>Kelola Produk
                                </a>
                                <a href="{{ route('penjualan.laporan.petugas') }}" class="btn btn-outline-light px-4 py-2 rounded-pill shadow-sm hover-scale">
                                    <i class="fas fa-chart-pie me-2"></i>Lihat Laporan
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-5 text-center">
                            <div class="admin-illustration">
                                <svg width="100%" viewBox="0 0 500 350" xmlns="http://www.w3.org/2000/svg" style="max-height: 250px;">
                                    <!-- Laptop Base -->
                                    <rect x="150" y="220" width="200" height="20" rx="3" fill="#e0e0e0" class="laptop-base"/>
                                    <rect x="170" y="240" width="160" height="12" rx="2" fill="#bdbdbd"/>
                                    
                                    <!-- Laptop Screen with Gradient -->
                                    <rect x="130" y="80" width="240" height="160" rx="6" fill="url(#screenGradient)"/>
                                    <rect x="140" y="90" width="220" height="140" rx="3" fill="#1a2035"/>
                                    
                                    <!-- Code Display with Animation -->
                                    <text x="150" y="120" font-family="'Courier New', monospace" font-size="12" fill="#4CAF50" class="code-line">
                                        <tspan x="150" dy="18">$ inventory-system start</tspan>
                                        <tspan x="150" dy="18">> Loading dashboard...</tspan>
                                        <tspan x="150" dy="18">> Connected to database</tspan>
                                        <tspan x="150" dy="18" class="text-warning">> Found {{ \App\Models\Produk::count() }} products</tspan>
                                        <tspan x="150" dy="18" fill="#FFC107">> System ready at {{ now()->format('H:i') }}</tspan>
                                    </text>
                                    
                                    <!-- Animated Status Lights -->
                                    <circle cx="430" cy="90" r="6" fill="#4CAF50" class="status-light pulse-green"/>
                                    <circle cx="430" cy="115" r="6" fill="#FFC107" class="status-light pulse-yellow"/>
                                    <circle cx="430" cy="140" r="6" fill="#FF5252" class="status-light pulse-red"/>
                                    
                                    <!-- Gradient Definition -->
                                    <defs>
                                        <linearGradient id="screenGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#4e73df"/>
                                            <stop offset="100%" stop-color="#224abe"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Card for Products -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm h-100 rounded-3 hover-lift bg-gradient-products">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-white bg-opacity-25 text-white me-4">
                            <i class="fas fa-boxes fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h2 class="fw-bold mb-1 display-5 text-white">{{ \App\Models\Produk::count() }}</h2>
                            <p class="text-white-50 mb-3">Total Produk</p>
                            <div class="d-flex gap-3">
                                <span class="badge bg-white text-danger rounded-pill px-3 py-1">
                                    {{ \App\Models\Produk::where('Stok', '<', 5)->count() }} Stok Kritis
                                </span>
                                <span class="badge bg-white text-warning rounded-pill px-3 py-1">
                                    {{ \App\Models\Produk::whereBetween('Stok', [5, 10])->count() }} Stok Rendah
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
        <div class="card-body p-0">
            <h5 class="fw-bold p-4 pb-2 mb-0">Aksi Cepat</h5>
            <div class="row g-0 text-center">
                <div class="col-6 col-md-4 quick-action-item">
                    <a href="{{ route('produk.create') }}" class="d-block p-4 text-decoration-none hover-grow">
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary mx-auto mb-3">
                            <i class="fas fa-plus fs-4"></i>
                        </div>
                        <h6 class="mb-0">Tambah Produk</h6>
                    </a>
                </div>
                <div class="col-6 col-md-4 quick-action-item">
                    <a href="{{ route('produk.index') }}" class="d-block p-4 text-decoration-none hover-grow">
                        <div class="icon-circle bg-success bg-opacity-10 text-success mx-auto mb-3">
                            <i class="fas fa-list fs-4"></i>
                        </div>
                        <h6 class="mb-0">Daftar Produk</h6>
                    </a>
                </div>
                <div class="col-6 col-md-4 quick-action-item">
                    <a href="{{ route('penjualan.laporan.petugas') }}" class="d-block p-4 text-decoration-none hover-grow">
                        <div class="icon-circle bg-warning bg-opacity-10 text-warning mx-auto mb-3">
                            <i class="fas fa-chart-pie fs-4"></i>
                        </div>
                        <h6 class="mb-0">Lihat Laporan</h6>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .bg-gradient-products {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }
    
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .blur-circle {
        filter: blur(40px);
        border-radius: 50%;
        position: absolute;
    }
    
    .hover-lift {
        transition: all 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.15) !important;
    }
    
    .hover-scale {
        transition: all 0.2s ease;
    }
    
    .hover-scale:hover {
        transform: scale(1.05);
    }
    
    .hover-grow:hover {
        transform: scale(1.03);
        background-color: rgba(0,0,0,0.02);
    }
    
    .pulse-green {
        animation: pulse-green 2s infinite;
    }
    
    .pulse-yellow {
        animation: pulse-yellow 2s infinite 0.5s;
    }
    
    .pulse-red {
        animation: pulse-red 2s infinite 1s;
    }
    
    @keyframes pulse-green {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }
    
    @keyframes pulse-yellow {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }
    
    @keyframes pulse-red {
        0% { opacity: 1; }
        50% { opacity: 0.3; }
        100% { opacity: 1; }
    }
    
    .quick-action-item {
        transition: all 0.3s ease;
        border-right: 1px solid rgba(0,0,0,0.05);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .quick-action-item:hover {
        background-color: rgba(0,0,0,0.02);
    }
    
    .quick-action-item:nth-child(3n) {
        border-right: none;
    }
    
    .quick-action-item:nth-last-child(-n+3) {
        border-bottom: none;
    }
    
    .admin-illustration .code-line tspan {
        opacity: 0;
        animation: fadeIn 0.5s forwards;
    }
    
    .admin-illustration .code-line tspan:nth-child(1) { animation-delay: 0.3s; }
    .admin-illustration .code-line tspan:nth-child(2) { animation-delay: 0.6s; }
    .admin-illustration .code-line tspan:nth-child(3) { animation-delay: 0.9s; }
    .admin-illustration .code-line tspan:nth-child(4) { animation-delay: 1.2s; }
    .admin-illustration .code-line tspan:nth-child(5) { animation-delay: 1.5s; }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @media (max-width: 768px) {
        .card-body.p-4 {
            padding: 1.5rem !important;
        }
        
        .icon-circle {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
        
        .display-5 {
            font-size: 2.5rem;
        }
        
        .quick-action-item {
            border-right: none;
        }
    }
</style>
@endsection
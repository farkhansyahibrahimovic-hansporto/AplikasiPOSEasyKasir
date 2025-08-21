@extends('layouts.petugas')

@section('content')
<div class="container-fluid py-4">
    <!-- Header dengan ilustrasi kasir yang lebih kuat -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-0">
                    <div class="row align-items-center">
                        <div class="col-md-6 p-4 p-lg-5">
                            <h1 class="fw-bold display-6 mb-3">Selamat Datang</h1>
                           <p class="lead mb-4">
                            Easy Kasir - Mudah, Cepat, Kadang Error 😅<br>
                            Maaf ya, kalau kadang suka ngambek... namanya juga aplikasi, bukan malaikat. 😇📲
                        </p>

                            <a href="{{ route('penjualan.create') }}" class="btn btn-light btn-lg rounded-pill px-4">
                                <i class="fas fa-cash-register me-2"></i>Mulai Transaksi & Penjualan
                            </a>
                        </div>
<!-- Struktur HTML -->
<div class="col-md-6 kasir-ilustrasi-container d-none d-md-block">
    <!-- Ilustrasi kasir modern -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 400" preserveAspectRatio="xMidYMid meet">
        <!-- Latar belakang -->
        <rect x="0" y="0" width="600" height="400" fill="#0d6efd" opacity="0.05"/>

        <!-- Kasir -->
        <g transform="translate(300, 180)">
            <!-- Kepala -->
            <circle cx="0" cy="-50" r="40" fill="#FFD3B6"/>
            
            <!-- Wajah -->
            <circle cx="-15" cy="-60" r="5" fill="#343a40"/>
            <circle cx="15" cy="-60" r="5" fill="#343a40"/>
            <path d="M-10,-40 Q0,-30 10,-40" stroke="#343a40" stroke-width="2" fill="none"/>

            <!-- Badan -->
            <path d="M-30,0 L30,0 L20,120 L-20,120 Z" fill="#6c757d"/>
            
            <!-- Tangan -->
            <path d="M-30,0 L-60,40 L-40,60 L-10,20 Z" fill="#FFD3B6"/>
            <path d="M30,0 L60,40 L40,60 L10,20 Z" fill="#FFD3B6"/>
            
            <!-- Mesin kasir -->
            <g class="mesin-kasir">
                <rect x="-80" y="30" width="160" height="90" rx="10" fill="#e9ecef"/>
                <rect x="-70" y="40" width="140" height="70" fill="#212529"/>
                <rect x="-60" y="50" width="120" height="30" fill="#495057"/>
                <rect x="-20" y="90" width="40" height="20" rx="5" fill="#28a745"/>
            </g>

            <!-- Barang belanjaan -->
            <g class="barang">
                <rect x="-150" y="50" width="40" height="30" rx="5" fill="#ffc107"/>
                <rect x="-140" y="30" width="20" height="20" rx="3" fill="#dc3545"/>
                <circle cx="-130" cy="90" r="15" fill="#17a2b8"/>
            </g>
        </g>

        <!-- Dekorasi tambahan -->
        <circle cx="100" cy="100" r="30" fill="white" opacity="0.05"/>
        <circle cx="500" cy="300" r="50" fill="white" opacity="0.05"/>
    </svg>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kartu statistik dengan ikon yang lebih besar -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body text-center p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <h3 class="fw-bold mb-1 display-5">{{\App\Models\Pelanggan::count()}}</h3>
                    <p class="text-muted mb-3">Pelanggan</p>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-users me-2"></i>Kelola
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body text-center p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </div>
                    <h3 class="fw-bold mb-1 display-5">{{ \App\Models\Produk::count() }}</h3>
                    <p class="text-muted mb-3">Stok & Pendataan Produk</p>
                    <a href="{{ route('produk.index') }}" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-boxes me-2"></i>Kelola
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body text-center p-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-4 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="fw-bold mb-1 display-5">{{ \App\Models\Penjualan::count() }}</h3>
                    <p class="text-muted mb-3">Transaksi & Penjualan</p>
                    <a href="{{ route('penjualan.index') }}" class="btn btn-info rounded-pill px-4">
                        <i class="fas fa-receipt me-2"></i>Kelola
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Daftar stok terbatas dan transaksi terakhir -->
    <div class="row">
        <!-- Stok terbatas -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 d-flex align-items-center" style="border-radius: 15px 15px 0 0;">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center p-3 me-3">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Stok Produk Terbatas</h5>
                </div>
                <div class="card-body">
                    @forelse(\App\Models\Produk::where('Stok', '<', 10)->orderBy('Stok', 'asc')->take(5)->get() as $produk)
                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded" style="transition: all 0.3s;">
                        <div class="bg-white rounded p-3 me-3 shadow-sm">
                            <i class="fas fa-box-open text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold">{{ $produk->NamaProduk }}</h6>
                            <small class="text-muted">Stok: {{ $produk->Stok }} | Harga: Rp {{ number_format($produk->Harga, 0, ',', '.') }}</small>
                        </div>
                        <span class="badge bg-{{ $produk->Stok <= 5 ? 'danger' : 'warning' }} py-2 px-3">
                            <i class="fas fa-{{ $produk->Stok <= 5 ? 'fire' : 'exclamation-circle' }} me-1"></i>
                            {{ $produk->Stok <= 5 ? 'Kritis' : 'Awas' }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076478.png" alt="No data" style="width: 120px; opacity: 0.5;">
                        <h5 class="mt-3 text-muted">Tidak ada stok terbatas</h5>
                        <p class="text-muted">Semua produk tersedia dengan stok cukup</p>
                    </div>
                    @endforelse
                </div>
                <div class="card-footer bg-white border-0" style="border-radius: 0 0 15px 15px;">
                    <a href="{{ route('produk.index') }}" class="btn btn-warning w-100 rounded-pill py-2">
                        <i class="fas fa-boxes me-2"></i>Kelola Produk
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Transaksi terakhir -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 d-flex align-items-center" style="border-radius: 15px 15px 0 0;">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center p-3 me-3">
                        <i class="fas fa-history text-danger"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Transaksi Terakhir</h5>
                </div>
                <div class="card-body">
                    @forelse(\App\Models\Penjualan::with('pelanggan')->latest()->take(5)->get() as $penjualan)
                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded" style="transition: all 0.3s;">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center p-3 me-3 shadow-sm">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold">{{ $penjualan->pelanggan->NamaPelanggan }}</h6>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($penjualan->TanggalPenjualan)->format('d M Y') }} • 
                                Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}
                            </small>
                        </div>
                        <span class="badge bg-success py-2 px-3">
                            <i class="fas fa-check-circle me-1"></i>Selesai
                        </span>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076478.png" alt="No data" style="width: 120px; opacity: 0.5;">
                        <h5 class="mt-3 text-muted">Belum ada transaksi</h5>
                        <p class="text-muted">Mulai lakukan transaksi pertama Anda</p>
                    </div>
                    @endforelse
                </div>
                <div class="card-footer bg-white border-0" style="border-radius: 0 0 15px 15px;">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-danger w-100 rounded-pill py-2">
                        <i class="fas fa-list me-2"></i>Lihat Semua
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick actions dengan bagian profil -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0 fw-bold">Akses Cepat</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-6 col-md-3 mb-4">
                            <a href="{{ route('penjualan.create') }}" class="btn btn-lg btn-outline-primary w-100 py-4 rounded-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="fas fa-cash-register fa-2x text-primary"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Transaksi Baru</h6>
                                <small class="text-muted d-block">Mulai transaksi baru</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <a href="{{ route('pelanggan.create') }}" class="btn btn-lg btn-outline-success w-100 py-4 rounded-3">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="fas fa-user-plus fa-2x text-success"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Tambah Pelanggan</h6>
                                <small class="text-muted d-block">Daftarkan pelanggan baru</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <a href="{{ route('produk.create') }}" class="btn btn-lg btn-outline-info w-100 py-4 rounded-3">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="fas fa-plus-circle fa-2x text-info"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Tambah Produk</h6>
                                <small class="text-muted d-block">Tambahkan produk baru</small>
                            </a>
                        </div>
                        <div class="col-6 col-md-3 mb-4">
                            <a href="{{ route('profile') }}" class="btn btn-lg btn-outline-warning w-100 py-4 rounded-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3">
                                    <i class="fas fa-user-cog fa-2x text-warning"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Profil Saya</h6>
                                <small class="text-muted d-block">Kelola akun Anda</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animasi dan efek hover */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .bg-light:hover {
        background-color: #f8f9fa !important;
        transform: translateY(-2px);
    }
    
    /* Tombol akses cepat */
    .btn-outline-primary:hover {
        background-color: rgba(13, 110, 253, 0.1);
    }
    .btn-outline-success:hover {
        background-color: rgba(25, 135, 84, 0.1);
    }
    .btn-outline-info:hover {
        background-color: rgba(13, 202, 240, 0.1);
    }
    .btn-outline-warning:hover {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    /* Ilustrasi kasir */
    .kasir-ilustrasi-container {
        text-align: center;
        padding: 2rem;
    }

    .kasir-ilustrasi-container svg {
        width: 100%;
        max-width: 400px;
        height: auto;
    }

    .mesin-kasir {
        filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.2));
    }

    .barang:hover {
        opacity: 0.8;
        transform: scale(1.05);
        transition: 0.3s ease;
    }
    
    /* Responsif */
    @media (max-width: 768px) {
        .display-6 {
            font-size: 1.8rem;
        }
        .lead {
            font-size: 1rem;
        }
        .btn-lg {
            padding: 0.5rem 1rem;
            font-size: 1rem;
        }
    }
</style>

<!-- Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
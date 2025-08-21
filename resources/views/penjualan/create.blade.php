@extends('layouts.petugas')

@section('title', 'Tambah Penjualan Baru')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-cart-plus mr-2"></i>Tambah Penjualan Baru</h5>
                        <a href="javascript:history.back()" class="btn btn-outline-light btn-sm ms-1">
                    <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {!! session('error') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('penjualan.store') }}" method="POST" id="penjualanForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="TanggalPenjualan" class="font-weight-bold">Tanggal Penjualan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('TanggalPenjualan') is-invalid @enderror" 
                                    id="TanggalPenjualan" name="TanggalPenjualan" 
                                    value="{{ old('TanggalPenjualan', date('Y-m-d')) }}" required>
                                @error('TanggalPenjualan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="PelangganID" class="font-weight-bold">Pelanggan <span class="text-danger">*</span></label>
                                <select class="form-control @error('PelangganID') is-invalid @enderror" 
                                    id="PelangganID" name="PelangganID" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach($pelangganList as $pelanggan)
                                        <option value="{{ $pelanggan->PelangganID }}" 
                                            {{ old('PelangganID') == $pelanggan->PelangganID ? 'selected' : '' }}>
                                            {{ $pelanggan->NamaPelanggan }} - {{ $pelanggan->NomorTelepon }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('PelangganID')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="PetugasInfo" class="font-weight-bold">Petugas</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="PetugasInfo" 
                                        value="{{ Auth::user()->name }}" readonly>
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-boxes mr-2"></i>Produk</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" id="produkTable">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="40%">Produk</th>
                                                <th width="15%">Harga</th>
                                                <th width="10%">Stok</th>
                                                <th width="15%">Jumlah</th>
                                                <th width="15%">Subtotal</th>
                                                <th width="5%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="produkRow_0">
                                                <td>
                                                    <select class="form-control produk-select" name="produk[0][ProdukID]" 
                                                        id="produk_0" data-row="0" required>
                                                        <option value="">-- Pilih Produk --</option>
                                                        @foreach($produkList as $produk)
                                                            <option value="{{ $produk->ProdukID }}" 
                                                                data-harga="{{ $produk->Harga }}" 
                                                                data-stok="{{ $produk->Stok }}">
                                                                {{ $produk->NamaProduk }} (Stok: {{ $produk->Stok }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp</span>
                                                        </div>
                                                        <input type="text" class="form-control harga-produk" id="harga_0" 
                                                            value="0" readonly>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control stok-produk text-center" id="stok_0" 
                                                        value="0" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control jumlah-produk text-center" 
                                                        name="produk[0][JumlahProduk]" id="jumlah_0" min="1" value="1" 
                                                        data-row="0" required>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp</span>
                                                        </div>
                                                        <input type="text" class="form-control subtotal-produk" 
                                                            name="produk[0][Subtotal]" id="subtotal_0" value="0" readonly>
                                                        <input type="hidden" name="produk[0][user_id]" value="{{ Auth::id() }}">
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <button type="button" class="btn btn-outline-danger btn-sm hapus-produk" 
                                                        data-row="0" disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer bg-white">
                                    <button type="button" class="btn btn-sm btn-primary" id="tambahProduk">
                                        <i class="fas fa-plus mr-1"></i> Tambah Produk
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="bg-light">Total Harga</th>
                                                <td class="text-right font-weight-bold">
                                                    <span id="TotalHargaDisplay">Rp 0</span>
                                                    <input type="hidden" name="TotalHarga" id="TotalHarga" value="0">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-outline-secondary mr-2" onclick="window.history.back()">
                                    <i class="fas fa-times mr-1"></i> Batal
                                </button>
                                <button type="submit" class="btn btn-primary" id="btnSimpan">
                                    <i class="fas fa-save mr-1"></i> Simpan Penjualan
                                </button>
                            </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        let rowCounter = 0;
        const formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });
        
        const userId = {{ Auth::id() }};

        // Fungsi untuk mencegah duplikasi produk
        function updateProductAvailability() {
            const selectedProducts = new Set();
            document.querySelectorAll('.produk-select').forEach(select => {
                if (select.value) {
                    selectedProducts.add(select.value);
                }
            });

            document.querySelectorAll('.produk-select').forEach(select => {
                const currentValue = select.value;
                Array.from(select.options).forEach(option => {
                    if (option.value && option.value !== currentValue && selectedProducts.has(option.value)) {
                        option.disabled = true;
                        option.style.color = '#999';
                    } else {
                        option.disabled = false;
                        option.style.color = '';
                    }
                });
            });
        }

        // Event untuk menambah baris produk baru
        document.getElementById('tambahProduk').addEventListener('click', function() {
            rowCounter++;
            
            const produkTable = document.querySelector('#produkTable tbody');
            const newRow = document.createElement('tr');
            newRow.id = `produkRow_${rowCounter}`;
            
            // Get data produk yang tersedia
            const produkOptions = Array.from(document.querySelector('#produk_0').options).map(option => {
                return `<option value="${option.value}" data-harga="${option.dataset.harga || 0}" data-stok="${option.dataset.stok || 0}">${option.text}</option>`;
            }).join('');
            
            newRow.innerHTML = `
                <td>
                    <select class="form-control produk-select" name="produk[${rowCounter}][ProdukID]" 
                        id="produk_${rowCounter}" data-row="${rowCounter}" required>
                        <option value="">-- Pilih Produk --</option>
                        ${produkOptions}
                    </select>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control harga-produk" id="harga_${rowCounter}" 
                            value="0" readonly>
                    </div>
                </td>
                <td>
                    <input type="text" class="form-control stok-produk text-center" id="stok_${rowCounter}" 
                        value="0" readonly>
                </td>
                <td>
                    <input type="number" class="form-control jumlah-produk text-center" 
                        name="produk[${rowCounter}][JumlahProduk]" id="jumlah_${rowCounter}" min="1" value="1" 
                        data-row="${rowCounter}" required>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" class="form-control subtotal-produk" 
                            name="produk[${rowCounter}][Subtotal]" id="subtotal_${rowCounter}" value="0" readonly>
                        <input type="hidden" name="produk[${rowCounter}][user_id]" value="${userId}">
                    </div>
                </td>
                <td class="text-center align-middle">
                    <button type="button" class="btn btn-outline-danger btn-sm hapus-produk" 
                        data-row="${rowCounter}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            
            produkTable.appendChild(newRow);
            
            // Tambahkan event listener untuk elemen baru
            attachEventListeners(rowCounter);
            
            // Panggil fungsi setelah menambah baris
            updateProductAvailability();
        });
        
        // Event delegasi untuk hapus baris produk
        document.querySelector('#produkTable').addEventListener('click', function(e) {
            if (e.target.classList.contains('hapus-produk') || e.target.closest('.hapus-produk')) {
                const btn = e.target.classList.contains('hapus-produk') ? e.target : e.target.closest('.hapus-produk');
                const rowId = btn.dataset.row;
                
                // Hapus baris jika bukan baris pertama
                if (rowId != 0) {
                    document.getElementById(`produkRow_${rowId}`).remove();
                    hitungTotal();
                    
                    // Panggil fungsi setelah menghapus baris
                    updateProductAvailability();
                }
            }
        });
        
        // Fungsi untuk menghitung subtotal dan total
        function hitungSubtotal(rowId) {
            const harga = parseFloat(document.getElementById(`harga_${rowId}`).value) || 0;
            const jumlah = parseInt(document.getElementById(`jumlah_${rowId}`).value) || 0;
            const stok = parseInt(document.getElementById(`stok_${rowId}`).value) || 0;
            
            // Validasi jumlah tidak melebihi stok
            if (jumlah > stok) {
                alert(`Jumlah produk tidak boleh melebihi stok yang tersedia (${stok})`);
                document.getElementById(`jumlah_${rowId}`).value = stok;
                return hitungSubtotal(rowId);
            }
            
            const subtotal = harga * jumlah;
            document.getElementById(`subtotal_${rowId}`).value = subtotal;
            
            hitungTotal();
        }
        
        // Fungsi untuk menghitung total keseluruhan
        function hitungTotal() {
            let total = 0;
            document.querySelectorAll('.subtotal-produk').forEach(function(el) {
                total += parseFloat(el.value) || 0;
            });
            
            document.getElementById('TotalHarga').value = total;
            document.getElementById('TotalHargaDisplay').textContent = formatter.format(total);
        }
        
        // Fungsi untuk mendapatkan data produk yang dipilih
        function getProductData(rowId) {
            const selectElement = document.getElementById(`produk_${rowId}`);
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            
            if (selectedOption && selectedOption.value) {
                const harga = parseFloat(selectedOption.dataset.harga) || 0;
                const stok = parseInt(selectedOption.dataset.stok) || 0;
                
                document.getElementById(`harga_${rowId}`).value = harga;
                document.getElementById(`stok_${rowId}`).value = stok;
                
                // Set jumlah default ke 1 atau stok jika stok < 1
                const jumlahInput = document.getElementById(`jumlah_${rowId}`);
                jumlahInput.max = stok;
                
                if (stok < 1) {
                    jumlahInput.value = 0;
                    jumlahInput.disabled = true;
                    alert('Stok produk ini tidak tersedia');
                } else {
                    jumlahInput.disabled = false;
                    // Pastikan jumlah tidak melebihi stok
                    if (parseInt(jumlahInput.value) > stok) {
                        jumlahInput.value = stok;
                    }
                }
                
                hitungSubtotal(rowId);
            } else {
                // Reset form jika tidak ada produk yang dipilih
                document.getElementById(`harga_${rowId}`).value = 0;
                document.getElementById(`stok_${rowId}`).value = 0;
                document.getElementById(`jumlah_${rowId}`).value = 1;
                document.getElementById(`subtotal_${rowId}`).value = 0;
                hitungTotal();
            }
            
            // Panggil fungsi setelah mengubah pilihan produk
            updateProductAvailability();
        }
        
        // Fungsi untuk menambahkan event listener ke elemen dalam baris
        function attachEventListeners(rowId) {
            const produkSelect = document.getElementById(`produk_${rowId}`);
            const jumlahInput = document.getElementById(`jumlah_${rowId}`);
            
            produkSelect.addEventListener('change', function() {
                getProductData(rowId);
            });
            
            jumlahInput.addEventListener('input', function() {
                hitungSubtotal(rowId);
            });
        }
        
        // Tambahkan event listener untuk baris pertama
        attachEventListeners(0);
        
        // Validasi form sebelum submit
        document.getElementById('penjualanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const totalHarga = parseFloat(document.getElementById('TotalHarga').value) || 0;
            
            if (totalHarga <= 0) {
                alert('Total harga tidak boleh 0. Silakan tambah produk.');
                return false;
            }
            
            // Periksa apakah ada produk yang dipilih
            let valid = false;
            document.querySelectorAll('.produk-select').forEach(function(el) {
                if (el.value) {
                    valid = true;
                }
            });
            
            if (!valid) {
                alert('Silakan pilih minimal 1 produk.');
                return false;
            }
            
            // Submit form jika semua validasi terpenuhi
            this.submit();
        });
    });
</script>
@endsection

@section('styles')
<style>
    .card-header {
        border-bottom: none;
    }
    .table th {
        white-space: nowrap;
    }
    .input-group-text {
        font-size: 0.875rem;
    }
    .form-control:read-only {
        background-color: #f8f9fa;
    }
    .text-center {
        text-align: center;
    }
    .align-middle {
        vertical-align: middle;
    }
    .bg-light {
        background-color: #f8f9fa!important;
    }
</style>
@endsection
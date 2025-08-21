@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Konfirmasi Hapus Penjualan</h5>
                </div>
                <div class="card-body">
                    <h5>Apakah Anda yakin ingin menghapus penjualan ini?</h5>
                <div class="alert alert-warning">
                    <p><strong>Perhatian!</strong> Tindakan ini akan:</p>
                    <ul>
                        <li>Menghapus seluruh data penjualan ini secara permanen</li>
                        <li>Mengembalikan stok produk yang terjual pada penjualan ini</li>
                        <li>Tindakan ini tidak dapat dibatalkan</li>
                    </ul>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Detail Penjualan</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">ID Penjualan</th>
                                <td>{{ $penjualan->PenjualanID }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ date('d-m-Y', strtotime($penjualan->TanggalPenjualan)) }}</td>
                            </tr>
                            <tr>
                                <th>Pelanggan</th>
                                <td>{{ $penjualan->pelanggan->NamaPelanggan }}</td>
                            </tr>
                            <tr>
                                <th>Total Harga</th>
                                <td>Rp {{ number_format($penjualan->TotalHarga, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <form action="{{ route('penjualan.delete', $penjualan->PenjualanID) }}" method="POST">
                    @csrf
                    <div class="d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Ya, Hapus Penjualan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
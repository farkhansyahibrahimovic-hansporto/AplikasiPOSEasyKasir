<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

class PenjualanController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Validasi akses dan session - hanya untuk petugas dan admin
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        // Ambil parameter filter dari request
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $pelangganId = $request->get('pelanggan_id');
        
        // Query dasar untuk mengambil penjualan
        $penjualanQuery = Penjualan::with(['pelanggan', 'detailPenjualan']);
        
        // Apply filter tanggal jika ada
        if ($startDate) {
            $penjualanQuery->where('TanggalPenjualan', '>=', $startDate);
        }
        
        if ($endDate) {
            $penjualanQuery->where('TanggalPenjualan', '<=', $endDate);
        }
        
        // Apply filter pelanggan jika ada
        if ($pelangganId) {
            $penjualanQuery->where('PelangganID', $pelangganId);
        }
        
        // Ambil semua data penjualan dengan filter
        $semuaPenjualan = $penjualanQuery->orderBy('TanggalPenjualan', 'desc')->get();
        
        // Mengambil data berpaginasi untuk informasi pagination
        $penjualanListQuery = Penjualan::query();
        
        // Apply filter yang sama untuk pagination
        if ($startDate) {
            $penjualanListQuery->where('TanggalPenjualan', '>=', $startDate);
        }
        
        if ($endDate) {
            $penjualanListQuery->where('TanggalPenjualan', '<=', $endDate);
        }
        
        if ($pelangganId) {
            $penjualanListQuery->where('PelangganID', $pelangganId);
        }
        
        $penjualanList = $penjualanListQuery->orderBy('TanggalPenjualan', 'desc')
            ->paginate(10)
            ->appends($request->query()); // Maintain filter parameters in pagination links
        
        // Menghitung statistik dari data yang sudah difilter
        $totalPenjualan = $semuaPenjualan->count();
        $totalPendapatan = $semuaPenjualan->sum('TotalHarga');
        
        // Hitung transaksi hari ini dari data yang sudah difilter
        $transaksiHariIni = $semuaPenjualan->filter(function ($item) {
            return Carbon::parse($item->TanggalPenjualan)->isToday();
        })->count();
        
        // Group penjualan berdasarkan tanggal untuk tampilan daily sales
        $groupedPenjualan = $semuaPenjualan->groupBy(function ($item) {
            return Carbon::parse($item->TanggalPenjualan)->toDateString();
        });
        
        // Ambil daftar pelanggan untuk dropdown filter
        $pelangganList = Pelanggan::orderBy('NamaPelanggan')->get();
        
        // Informasi filter yang diterapkan
        $filterInfo = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'pelanggan_id' => $pelangganId,
            'pelanggan_nama' => $pelangganId ? Pelanggan::find($pelangganId)->NamaPelanggan : null
        ];
        
        return view('penjualan.index', compact(
            'penjualanList', 
            'semuaPenjualan',
            'totalPenjualan',
            'transaksiHariIni',
            'totalPendapatan',
            'groupedPenjualan',
            'pelangganList',
            'filterInfo'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Validasi akses dan session - hanya untuk petugas dan admin
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        $pelangganList = Pelanggan::orderBy('NamaPelanggan')->get();
        $produkList = Produk::where('Stok', '>', 0) // Only show products with stock
            ->orderBy('NamaProduk')
            ->get();
            
        return view('penjualan.create', compact('pelangganList', 'produkList'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi akses dan session - hanya untuk petugas dan admin
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        $request->validate([
            'TanggalPenjualan' => 'required|date',
            'PelangganID' => 'required|exists:pelanggan,PelangganID',
            'produk' => 'required|array|min:1',
            'produk.*.ProdukID' => 'required|exists:produk,ProdukID',
            'produk.*.JumlahProduk' => 'required|integer|min:1',
            'TotalHarga' => 'required|numeric|min:1',
        ]);
        
        // Dapatkan ID user yang sedang login (petugas)
        $petugasId = Auth::id();
        
        DB::beginTransaction();
        try {
            // Validate stock before creating the sale
            $invalidProducts = [];
            foreach ($request->produk as $item) {
                $produk = Produk::find($item['ProdukID']);
                if (!$produk || $produk->Stok < $item['JumlahProduk']) {
                    $invalidProducts[] = [
                        'produk' => $produk ? $produk->NamaProduk : 'Unknown',
                        'stok' => $produk ? $produk->Stok : 0,
                        'permintaan' => $item['JumlahProduk']
                    ];
                }
            }
            
            if (!empty($invalidProducts)) {
                $errorMessage = "Stok produk tidak mencukupi:<br>";
                foreach ($invalidProducts as $invalid) {
                    $errorMessage .= "- {$invalid['produk']} (Stok: {$invalid['stok']}, Permintaan: {$invalid['permintaan']})<br>";
                }
                throw new Exception($errorMessage);
            }
            
            // Create penjualan record
            $penjualan = Penjualan::create([
                'TanggalPenjualan' => $request->TanggalPenjualan,
                'PelangganID' => $request->PelangganID,
                'TotalHarga' => $request->TotalHarga,
            ]);
            
            // Process each product in the sale
            foreach ($request->produk as $item) {
                $produk = Produk::find($item['ProdukID']);
                
                // Create detail penjualan record
                DetailPenjualan::create([
                    'PenjualanID' => $penjualan->PenjualanID,
                    'ProdukID' => $item['ProdukID'],
                    'user_id' => $petugasId, // Petugas yang login
                    'JumlahProduk' => $item['JumlahProduk'],
                    'Subtotal' => $item['Subtotal'],
                ]);
                
                // Update stock
                $produk->decrement('Stok', $item['JumlahProduk']);
            }
            
            DB::commit();
            
            return redirect()->route('penjualan.index', $penjualan->PenjualanID)
                ->with('success', 'Penjualan berhasil disimpan');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // Validasi akses dan session - hanya untuk petugas dan admin
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualan.produk', 'detailPenjualan.petugas'])
            ->findOrFail($id);
            
        return view('penjualan.show', compact('penjualan'));
    }
    
    /**
     * Generate print view for the specified penjualan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request, $id)
    {
        // Validasi akses dan session - hanya untuk petugas dan admin
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualan.produk', 'detailPenjualan.petugas'])
            ->findOrFail($id);
            
        return view('penjualan.print', compact('penjualan'));
    }

    /**
     * Generate print view for all penjualan data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function printAll(Request $request)
    {
        // Validasi akses dan session - hanya untuk admin dan petugas
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        // Ambil parameter filter dari request
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $pelangganId = $request->get('pelanggan_id');
        
        // Query dasar untuk mengambil semua penjualan
        $query = Penjualan::with(['pelanggan', 'detailPenjualan.produk', 'detailPenjualan.petugas']);
        
        // Apply filter tanggal jika ada
        if ($startDate) {
            $query->where('TanggalPenjualan', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('TanggalPenjualan', '<=', $endDate);
        }
        
        // Apply filter pelanggan jika ada
        if ($pelangganId) {
            $query->where('PelangganID', $pelangganId);
        }
        
        // Ambil data dengan urutan terbaru
        $semuaPenjualan = $query->orderBy('TanggalPenjualan', 'desc')->get();
        
        // Hitung statistik
        $totalTransaksi = $semuaPenjualan->count();
        $totalPendapatan = $semuaPenjualan->sum('TotalHarga');
        $totalItem = $semuaPenjualan->sum(function($penjualan) {
            return $penjualan->detailPenjualan->sum('JumlahProduk');
        });
        
        // Group penjualan berdasarkan tanggal
        $groupedPenjualan = $semuaPenjualan->groupBy(function ($item) {
            return Carbon::parse($item->TanggalPenjualan)->toDateString();
        });
        
        // Informasi filter yang diterapkan
        $filterInfo = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'pelanggan_id' => $pelangganId,
            'pelanggan_nama' => $pelangganId ? Pelanggan::find($pelangganId)->NamaPelanggan : null
        ];
        
        return view('penjualan.print-all', compact(
            'semuaPenjualan',
            'groupedPenjualan', 
            'totalTransaksi',
            'totalPendapatan',
            'totalItem',
            'filterInfo'
        ));
    }

    /**
     * Generate print view for all sales data with filtering options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function printAllSalesReport(Request $request)
    {
        // Validasi akses dan session - hanya untuk admin dan petugas
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        // Ambil parameter filter dari request
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $pelangganId = $request->get('pelanggan_id');
        $petugasId = $request->get('petugas_id');
        
        // Query dasar untuk mengambil semua penjualan
        $query = Penjualan::with(['pelanggan', 'detailPenjualan.produk', 'detailPenjualan.petugas']);
        
        // Apply filter tanggal jika ada
        if ($startDate) {
            $query->where('TanggalPenjualan', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('TanggalPenjualan', '<=', $endDate);
        }
        
        // Apply filter pelanggan jika ada
        if ($pelangganId) {
            $query->where('PelangganID', $pelangganId);
        }
        
        // Apply filter petugas jika ada
        if ($petugasId) {
            $query->whereHas('detailPenjualan', function($q) use ($petugasId) {
                $q->where('user_id', $petugasId);
            });
        }
        
        // Ambil data dengan urutan terbaru
        $semuaPenjualan = $query->orderBy('TanggalPenjualan', 'desc')->get();
        
        // Hitung statistik
        $totalTransaksi = $semuaPenjualan->count();
        $totalPendapatan = $semuaPenjualan->sum('TotalHarga');
        $totalItem = $semuaPenjualan->sum(function($penjualan) {
            return $penjualan->detailPenjualan->sum('JumlahProduk');
        });
        
        // Group penjualan berdasarkan tanggal
        $groupedPenjualan = $semuaPenjualan->groupBy(function ($item) {
            return Carbon::parse($item->TanggalPenjualan)->toDateString();
        });
        
        // Informasi filter yang diterapkan
        $filterInfo = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'pelanggan_id' => $pelangganId,
            'pelanggan_nama' => $pelangganId ? Pelanggan::find($pelangganId)->NamaPelanggan : null,
            'petugas_id' => $petugasId,
            'petugas_nama' => $petugasId ? User::find($petugasId)->name : null
        ];
        
        return view('penjualan.laporan-print-all', compact(
            'semuaPenjualan',
            'groupedPenjualan', 
            'totalTransaksi',
            'totalPendapatan',
            'totalItem',
            'filterInfo'
        ));
    }
        
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // Validasi akses dan session
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        return redirect()->route('penjualan.show', $id)
            ->with('error', 'Penjualan tidak dapat diedit setelah disimpan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi akses dan session
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        return redirect()->route('penjualan.show', $id)
            ->with('error', 'Penjualan tidak dapat diubah setelah disimpan');
    }

    /**
     * Show confirmation page before deleting a resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Request $request, $id)
    {
        // Validasi akses dan session - hanya untuk admin
        $accessCheck = $this->validateAccess($request, ['administrator']);
        if ($accessCheck !== true) {
            return redirect()->route('penjualan.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus penjualan');
        }
        
        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualan'])
            ->findOrFail($id);
            
        return view('penjualan.confirm-delete', compact('penjualan'));
    }

    /**
     * Delete the specified resource from storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        // Validasi akses dan session - hanya untuk admin
        $accessCheck = $this->validateAccess($request, ['administrator']);
        if ($accessCheck !== true) {
            return redirect()->route('penjualan.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus penjualan');
        }
        
        DB::beginTransaction();
        try {
            // Cari penjualan yang akan dihapus
            $penjualan = Penjualan::with('detailPenjualan')->findOrFail($id);
            
            // Kembalikan stok produk yang terkait dengan penjualan
            foreach ($penjualan->detailPenjualan as $detail) {
                $produk = Produk::find($detail->ProdukID);
                if ($produk) {
                    $produk->increment('Stok', $detail->JumlahProduk);
                }
            }
            
            // Hapus detail penjualan terlebih dahulu
            DetailPenjualan::where('PenjualanID', $id)->delete();
            
            // Hapus penjualan
            $penjualan->delete();
            
            DB::commit();
            
            // Check referer to determine where to redirect
            $referer = $request->header('referer');
            
            if (strpos($referer, 'laporan/petugas') !== false) {
                return redirect()->route('penjualan.laporan.petugas')
                    ->with('success', 'Penjualan berhasil dihapus dan stok produk telah dikembalikan');
            }
            
            return redirect()->route('penjualan.index')
                ->with('success', 'Penjualan berhasil dihapus dan stok produk telah dikembalikan');
                
        } catch (Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus penjualan: ' . $e->getMessage());
        }
    }

    /**
     * Legacy destroy method (keeping for backwards compatibility).
     * Now this redirects to the new delete method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        return $this->delete($request, $id);
    }
    
    /**
     * API endpoint to get product details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProductDetails(Request $request)
    {
        // Validasi akses dan session
        $accessCheck = $this->validateAccess($request, ['administrator', 'petugas']);
        if ($accessCheck !== true) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $request->validate([
            'produk_id' => 'required|exists:produk,ProdukID'
        ]);
        
        $produk = Produk::find($request->produk_id);
        
        return response()->json([
            'nama' => $produk->NamaProduk,
            'harga' => $produk->Harga,
            'stok' => $produk->Stok,
        ]);
    }

    /**
     * Menampilkan laporan penjualan per petugas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function laporanPenjualanPerPetugas(Request $request)
    {
        // Validasi akses dan session - hanya untuk admin
        $accessCheck = $this->validateAccess($request, ['administrator']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }

        // Ambil parameter filter dari request
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        // Query dasar untuk laporan per petugas
        $laporanQuery = DB::table('detailpenjualan')
            ->join('users', 'detailpenjualan.user_id', '=', 'users.id')
            ->join('penjualan', 'detailpenjualan.PenjualanID', '=', 'penjualan.PenjualanID');
            
        // Apply filter tanggal jika ada
        if ($startDate) {
            $laporanQuery->where('penjualan.TanggalPenjualan', '>=', $startDate);
        }
        
        if ($endDate) {
            $laporanQuery->where('penjualan.TanggalPenjualan', '<=', $endDate);
        }
        
        // Laporan total penjualan per petugas
        $laporanPetugas = $laporanQuery
            ->select('users.name', 'users.id', 
                DB::raw('COUNT(DISTINCT detailpenjualan.PenjualanID) as total_transaksi'),
                DB::raw('SUM(detailpenjualan.Subtotal) as total_penjualan'))
            ->groupBy('users.id', 'users.name')
            ->get();

        // Query untuk mengambil semua data penjualan
        $penjualanQuery = Penjualan::with(['detailPenjualan.petugas', 'pelanggan']);
        
        // Apply filter tanggal yang sama
        if ($startDate) {
            $penjualanQuery->where('TanggalPenjualan', '>=', $startDate);
        }
        
        if ($endDate) {
            $penjualanQuery->where('TanggalPenjualan', '<=', $endDate);
        }
        
        // Ambil seluruh data penjualan dengan filter
        $semuaPenjualan = $penjualanQuery->orderBy('TanggalPenjualan', 'desc')->get();

        // Grouping berdasarkan tanggal penjualan
        $groupedPenjualan = $semuaPenjualan->groupBy(function ($item) {
            return Carbon::parse($item->TanggalPenjualan)->toDateString();
        });
        
        // Informasi filter yang diterapkan
        $filterInfo = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        // Kirim data ke view
        return view('penjualan.laporan-petugas', compact(
            'laporanPetugas', 
            'groupedPenjualan',
            'filterInfo'
        ));
    }
    
    /**
     * Menampilkan detail penjualan untuk petugas tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id  ID petugas
     * @return \Illuminate\Http\Response
     */
    public function detailPenjualanPetugas(Request $request, $id)
    {
        // Validasi akses dan session - hanya untuk admin
        $accessCheck = $this->validateAccess($request, ['administrator']);
        if ($accessCheck !== true) {
            return $accessCheck;
        }
        
        // Ambil parameter filter dari request
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        // Ambil data petugas
        $petugas = User::findOrFail($id);
        
        // Query dasar untuk detail penjualan petugas
        $detailQuery = DB::table('detailpenjualan')
            ->join('penjualan', 'detailpenjualan.PenjualanID', '=', 'penjualan.PenjualanID')
            ->join('produk', 'detailpenjualan.ProdukID', '=', 'produk.ProdukID')
            ->join('pelanggan', 'penjualan.PelangganID', '=', 'pelanggan.PelangganID')
            ->where('detailpenjualan.user_id', $id);
            
        // Apply filter tanggal jika ada
        if ($startDate) {
            $detailQuery->where('penjualan.TanggalPenjualan', '>=', $startDate);
        }
        
        if ($endDate) {
            $detailQuery->where('penjualan.TanggalPenjualan', '<=', $endDate);
        }
            
        // Ambil detail penjualan yang ditangani oleh petugas
        $detailPenjualan = $detailQuery
            ->select(
                'penjualan.PenjualanID',
                'penjualan.TanggalPenjualan',
                'pelanggan.NamaPelanggan',
                'produk.NamaProduk',
                'detailpenjualan.JumlahProduk',
                'detailpenjualan.Subtotal'
            )
            ->orderBy('penjualan.TanggalPenjualan', 'desc')
            ->get();
        
        // Hitung total penjualan
        $totalPenjualan = $detailPenjualan->sum('Subtotal');
        
        // Informasi filter yang diterapkan
        $filterInfo = [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
        
        return view('penjualan.detail-petugas', compact(
            'petugas', 
            'detailPenjualan', 
            'totalPenjualan',
            'filterInfo'
        ));
    }
}
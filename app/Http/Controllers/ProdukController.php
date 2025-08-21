<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }
    
    public function create()
    {
        return view('produk.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga' => 'required|numeric|min:0',
            'Stok' => 'required|integer|min:0',
        ]);
        Produk::create($request->all());
        
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
    
    public function show(Produk $produk)
    {
        return view('produk.show', compact('produk'));
    }
    
    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }
    
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'NamaProduk' => 'required|string|max:255',
            'Harga' => 'required|numeric|min:0',
            'Stok' => 'required|integer|min:0',
        ]);
        
        $produk->update($request->all());
        
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }
    public function destroy(Produk $produk)
    {
        $produk->delete();
        
        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}


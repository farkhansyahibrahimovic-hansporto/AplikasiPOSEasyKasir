<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detailpenjualan', function (Blueprint $table) {
            $table->id('DetailID');
            $table->foreignId('PenjualanID')->constrained('penjualan', 'PenjualanID')->onDelete('cascade');
            $table->foreignId('ProdukID')->constrained('produk', 'ProdukID');
            $table->foreignId('user_id')->constrained('users')->comment('ID Petugas yang melakukan penjualan');
            $table->integer('JumlahProduk');
            $table->decimal('Subtotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailpenjualan');
    }
};
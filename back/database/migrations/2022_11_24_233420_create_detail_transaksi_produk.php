<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi_produk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk');
            $table->string('nama_barang');
            $table->integer('jumlah_barang');
            $table->integer('harga');
            $table->string('nama_kasir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksi_produk');
    }
};

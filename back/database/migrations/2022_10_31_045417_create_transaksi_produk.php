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
        Schema::create('transaksi_produk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi',50);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('jumlah_barang');
            $table->dateTime('tanggal_transaksi_produk');
            $table->integer('total_harga_produk');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('id_produk')->references('id')->on('produk');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_produk');
    }
};

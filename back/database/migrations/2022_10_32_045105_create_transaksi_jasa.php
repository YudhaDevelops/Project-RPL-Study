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
        Schema::create('transaksi_jasa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi_jasa');
            $table->unsignedBigInteger('kasir_id');
            $table->string('id_hewan');
            $table->unsignedBigInteger('jasa_id')->nullable();
            $table->dateTime('tanggal_transaksi_jasa');
            $table->integer('total_harga_jasa');
            $table->boolean('is_bayar')->default('0');
            $table->timestamps();

            $table->foreign('kasir_id')->references('id')->on('users');
            $table->foreign('id_hewan')->references('id_hewan')->on('hewan');
            $table->foreign('jasa_id')->references('id')->on('jasa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_jasa');
    }
};

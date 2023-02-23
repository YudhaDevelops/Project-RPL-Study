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
        Schema::create('pembayaran_jasa', function (Blueprint $table) {
            $table->id();
            $table->string('id_hewan');
            $table->unsignedBigInteger('id_jasa')->nullable();
            $table->integer('durasi')->nullable();
            $table->timestamps();

            $table->foreign('id_hewan')->references('id_hewan')->on('hewan');
            $table->foreign('id_jasa')->references('id')->on('jasa');

            //nb kenapa gak total harga jasa karena total nanti akan di proses di controller
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran_jasa');
    }
};

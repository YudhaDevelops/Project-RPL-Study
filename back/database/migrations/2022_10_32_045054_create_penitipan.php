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
        Schema::create('penitipan', function (Blueprint $table) {
            $table->id();
            $table->string('id_hewan');
            $table->unsignedBigInteger('id_jasa');
            $table->integer('no_kandang');
            $table->dateTime('tanggal_masuk')->nullable();
            $table->dateTime('tanggal_keluar')->nullable();
            $table->boolean('is_selesai')->nullable()->default(0);
            $table->timestamps();
            
            $table->foreign('id_hewan')->references('id_hewan')->on('hewan');
            $table->foreign('id_jasa')->references('id')->on('jasa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penitipan');
    }
};

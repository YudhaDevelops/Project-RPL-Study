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
        Schema::create('grooming', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jasa');
            $table->string('id_hewan');
            $table->enum('tahapan', ['Pendataan','Proses','Selesai']);
            $table->date('tanggal_grooming')->format('d-m-Y')->nullable();
            $table->time("waktu_masuk");
            $table->time("waktu_keluar");
            
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
        Schema::dropIfExists('grooming');
    }
};

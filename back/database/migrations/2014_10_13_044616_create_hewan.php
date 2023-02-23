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
        Schema::create('hewan', function (Blueprint $table) {
            $table->string('id_hewan');
            $table->unsignedBigInteger('id_user');
            $table->string('nama_hewan', 100);
            $table->enum('tipe_hewan', ['Kucing', 'Anjing']);
            $table->string('umur_hewan');
            $table->string('gambar_hewan', 255)->nullable();
            $table->timestamps();

            $table->primary('id_hewan');
            $table->foreign('id_user')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hewan');
    }
};

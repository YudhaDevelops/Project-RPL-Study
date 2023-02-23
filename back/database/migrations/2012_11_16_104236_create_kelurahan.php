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
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->char('id', 10);
            $table->char('kecamatan_id', 7);
            $table->string('nama', 255);

            $table->primary('id');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('kelurahan');
        if (Schema::hasTable('kelurahan')) {
            Schema::table('alamat', function (Blueprint $table) {
                $table->dropForeign('alamat_kelurahan_id_foreign');
            });

            Schema::drop('kelurahan');
        }
    }
};

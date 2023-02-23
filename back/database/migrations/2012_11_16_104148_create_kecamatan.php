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
        Schema::create('kecamatan', function (Blueprint $table) {
            $table->char('id', 7);
            $table->char('kabupaten_id', 4);
            $table->string('nama', 255);

            $table->primary('id');
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('kecamatan')) {
            Schema::table('kelurahan', function (Blueprint $table) {
                $table->dropForeign('kelurahan_kecamatan_id_foreign');
            });

            Schema::drop('kecamatan');
        }
    }
};

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
        Schema::create('kabupaten', function (Blueprint $table) {
            $table->char('id', 4);
            $table->char('provinsi_id', 2);
            $table->string('nama', 255);

            $table->primary('id');
            $table->foreign('provinsi_id')->references('id')->on('provinsi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('kabupaten')) {
            Schema::table('kecamatan', function (Blueprint $table) {
                $table->dropForeign('kecamatan_kabupaten_id_foreign');
            });

            Schema::drop('kabupaten');
        }
    }
};

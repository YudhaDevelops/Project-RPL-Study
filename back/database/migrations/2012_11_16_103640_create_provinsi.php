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
        Schema::create('provinsi', function (Blueprint $table) {
            $table->char('id',2);
            $table->string('nama',255);
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('provinsi')) {
            Schema::table('kabupaten', function (Blueprint $table) {
                $table->dropForeign('kabupaten_provinsi_id_foreign');
            });

            Schema::drop('provinsi');
        }
    }
};

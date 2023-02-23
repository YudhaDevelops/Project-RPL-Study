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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('nama_lengkap');
            $table->enum('gender', ['Laki-Laki','Perempuan']);
            $table->string('no_telepon', 12);
            $table->string('foto_profile',20)->nullable();
            $table->integer("role");
            $table->string('password')->unique();
            $table->unsignedBigInteger('id_alamat')->nullable();
            $table->timestamp('email_verified_at')->nullable();            
            $table->rememberToken(); 
            $table->timestamps();

            $table->foreign('id_alamat')->references('id')->on('alamat');
        }); 
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

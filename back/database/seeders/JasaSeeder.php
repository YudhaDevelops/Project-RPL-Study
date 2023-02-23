<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JasaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
            DB::table('jasa')->insert([
                'id'=> 1,
                'nama_jasa' => "Penitipan",
                'harga_jasa' => 20000,
                'gambar_jasa' => null,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
            
            DB::table('jasa')->insert([
                'id'=> 2,
                'nama_jasa' => "Grooming Standar",
                'harga_jasa' => 25000,
                'gambar_jasa' => null,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
        
            DB::table('jasa')->insert([
                'id'=> 3,
                'nama_jasa' => "Grooming Spesial",
                'harga_jasa' => 25000,
                'gambar_jasa' => null,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
    }
}

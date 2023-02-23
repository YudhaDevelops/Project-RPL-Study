<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OlahDataProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('id_ID');
        for ($i=1; $i <= 10; $i++) { 
            DB::table('olah_data_produks')->insert([
                'id_olah_data_produk'=> $i,
                'id_user' => $i,
                'id_produk' => $i,
                'tanggal_edit' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}

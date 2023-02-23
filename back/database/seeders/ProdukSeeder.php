<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
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
            if ($i < 6) {
                $code = 'PK' .rand(1000000,9999999);
            } else {
                $code = 'PA' .rand(1000000,9999999);
            }
            
            DB::table('produk')->insert([
                'kode_produk'=> $code,
                'nama_produk' => $faker->name,
                'bobot' => rand(1000,9999),
                'harga' => rand(10000,99999),
                'stok' => rand(100,999),
                'gambar_produk' => null,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
        }
    }
}

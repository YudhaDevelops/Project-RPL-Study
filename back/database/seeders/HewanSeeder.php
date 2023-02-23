<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HewanSeeder extends Seeder
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
            if ($i > 5) {
                $tipe = "Anjing";
            }else{
                $tipe = "Kucing";
            }
            DB::table('hewan')->insert([
                'id_hewan'      => $i,
                'id_user'       => $i,
                'nama_hewan'    => $faker->name,
                'tipe_hewan'    => $tipe,
                'umur_hewan'    => $faker->randomDigit,
                'gambar_hewan'  => "123.png",
                'created_at'    =>date('Y-m-d H:i:s'),
                'updated_at'    =>date('Y-m-d H:i:s')
            ]);
        }
    }
}

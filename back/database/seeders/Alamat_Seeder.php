<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Alamat_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i=1; $i <= 4; $i++) { 
            DB::table('alamat')->insert([
                'detail_alamat'=>$faker->address,
                'provinsi' => $faker->country,
                'kabupaten' => $faker->name,
                'kecamatan' => $faker->name,
                'kelurahan' => $faker->name,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        DB::table('users')->insert([
            'nama_lengkap'=>$faker->name,
            'email' => "kasir@gmail.com",
            'gender' => "Perempuan",
            'no_telepon' => $faker->randomDigit,
            'role' => 1,
            'password' => Hash::make("kasir123"),
            'id_alamat' => 1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('users')->insert([
            'nama_lengkap'=>$faker->name,
            'email' => "owner@gmail.com",
            'gender' => "Perempuan",
            'no_telepon' => $faker->randomDigit,
            'role' => 2,
            'password' => Hash::make("owner123"),
            'id_alamat' => 2,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);


        // for ($i=1; $i <= 10; $i++) { 
        //     DB::table('users')->insert([
        //         'nama_lengkap'=>$faker->name,
        //         'email' => $faker->email,
        //         'gender' => "Perempuan",
        //         'no_telepon' => $faker->randomDigit,
        //         'role' => 0,
        //         'password' => Hash::make("admin123"),
        //         'id_alamat' => $i,
        //         'created_at'=>date('Y-m-d H:i:s'),
        //         'updated_at'=>date('Y-m-d H:i:s')
        //     ]);
        // }
    }
}

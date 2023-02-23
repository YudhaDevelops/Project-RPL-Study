<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransaksiJasaSeeder extends Seeder
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
            DB::table('transaksi_jasa')->insert([
                'id_transaksi_jasa'=> $i,
                'id_user' => $i,
                'jasa_id' => $i,
                'tanggal_transaksi_jasa' => date('Y-m-d H:i:s'),
                'total_harga_jasa' => 100000,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
        }
    }
}

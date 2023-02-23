<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kecamatan')->delete();

        $csvFile = fopen(base_path("database/data/districts.csv"), "r");

        $firstline = false;
        $fp = file(base_path("database/data/villages.csv"), FILE_SKIP_EMPTY_LINES);
        $this->command->getOutput()->progressStart(count($fp));
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Kecamatan::create([
                    "id" => $data['0'],
                    "kabupaten_id" => $data['1'],
                    "nama" => $data['2']
                ]);
                $this->command->getOutput()->progressAdvance();
            }
            $firstline = false;
        }
        $this->command->getOutput()->progressFinish();
        fclose($csvFile);
    }
}

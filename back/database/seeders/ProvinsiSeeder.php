<?php

namespace Database\Seeders;

use App\Models\Provinsi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinsi')->delete();

        $csvFile = fopen(base_path("database/data/provinces.csv"), "r");

        $firstline = false;
        $fp = file(base_path("database/data/provinces.csv"), FILE_SKIP_EMPTY_LINES);
        $this->command->getOutput()->progressStart(count($fp));
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Provinsi::create([
                    "id" => $data['0'],
                    "nama" => $data['1'],
                ]);
                $this->command->getOutput()->progressAdvance();
            }
            $firstline = false;
        }
        $this->command->getOutput()->progressFinish();
        fclose($csvFile);
    }
}

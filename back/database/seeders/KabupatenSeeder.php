<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kabupaten')->delete();

        $csvFile = fopen(base_path("database/data/regencies.csv"), "r");

        $firstline = false;
        $fp = file(base_path("database/data/regencies.csv"), FILE_SKIP_EMPTY_LINES);
        $this->command->getOutput()->progressStart(count($fp));
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Kabupaten::create([
                    "id" => $data['0'],
                    "provinsi_id" => $data['1'],
                    "nama" => $data['2'],
                ]);
                $this->command->getOutput()->progressAdvance();
            }
            $firstline = false;
        }
        $this->command->getOutput()->progressFinish();
        fclose($csvFile);
    }
}

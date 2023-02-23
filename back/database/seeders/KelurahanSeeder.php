<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kelurahan')->delete();

        $csvFile = fopen(base_path("database/data/villages.csv"), "r");

        $firstline = false;
        $fp = file(base_path("database/data/villages.csv"), FILE_SKIP_EMPTY_LINES);
        $this->command->getOutput()->progressStart(count($fp));
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                // if (Kelurahan::where('id', $data['0'])->first() == null) {
                Kelurahan::create([
                    "id" => $data['0'],
                    "kecamatan_id" => $data['1'],
                    "nama" => $data['2']
                ]);
                // }
                $this->command->getOutput()->progressAdvance();
            }
            $firstline = false;
        }
        $this->command->getOutput()->progressFinish();
        fclose($csvFile);
    }
}

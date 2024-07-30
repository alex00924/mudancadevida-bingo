<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CSVBingoCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 6; $i++) {
            $path = storage_path() . "/csv/$i.CSV";
            $delimiter = ";";
            if (($handle = fopen($path, "r")) === false)
            {
                print("can't open file $i");
                continue;
            }

            $csv_headers = fgetcsv($handle, 4000, $delimiter);
            $bingoCardData = [];
            $nCnt = 0;

            while ($row = fgetcsv($handle, 4000, $delimiter))
            {
                if (count($csv_headers) != count($row)) {
                    var_dump($row);
                    continue;
                }
                $bingoCard = array_combine($csv_headers, $row);
                if ($nCnt == 1000) {
                    DB::table('bingo_cards')->insert($bingoCardData);
                    $nCnt = 0;
                    $bingoCardData = [];
                }
                $nCnt++;
                $data = [];
                for($k = 1; $k < 26; $k++) {
                    $data["d$k"] = $bingoCard["D$k"];
                }
                $data['card_number'] = str_pad($bingoCard['CartelaD'], 6, '0', STR_PAD_LEFT);
                $data['card_digit'] = $bingoCard['DigitoD'];
                $bingoCardData[] = $data;
            }
            DB::table('bingo_cards')->insert($bingoCardData);

            fclose($handle);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BingoCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path() . "/json/bingo_cards.json";
        $BINGO_CARDS = json_decode(file_get_contents($path), true); 

        $bingoCardData = [];
        $nCnt = 0;
        foreach($BINGO_CARDS as $bingoCard ) {
            if ($nCnt == 1000) {
                DB::table('bingo_cards')->insert($bingoCardData);
                $nCnt = 0;
                $bingoCardData = [];
            }
            $nCnt++;
            $data = [];
            for($i = 1; $i < 26; $i++) {
                $data["d$i"] = $bingoCard["D$i"];
            }
            $data['card_number'] = str_pad($bingoCard['CartelaD'], 6, '0', STR_PAD_LEFT);
            $data['card_digit'] = $bingoCard['DigitoD'];
            $bingoCardData[] = $data;
        }

        DB::table('bingo_cards')->insert($bingoCardData);
    }
}

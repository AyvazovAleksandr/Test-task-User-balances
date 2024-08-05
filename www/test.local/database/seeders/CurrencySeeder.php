<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'id' => 1,
                'name' => 'United States dollar',
                'symbol' => '$',
                'iso_code_str' => 'USD',
                'iso_code_num' => 840,
                'exchange_currency' => 100,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'id' => 2,
                'name' => 'Euro',
                'symbol' => '€',
                'iso_code_str' => 'EUR',
                'iso_code_num' => 978,
                'exchange_currency' => 100,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'id' => 3,
                'name' => 'Russian ruble',
                'symbol' => '₽',
                'iso_code_str' => 'RUB',
                'iso_code_num' => 643,
                'exchange_currency' => 100,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
        ];

        DB::table('currencies')->truncate();
        DB::table('currencies')->insert($currencies);
    }
}

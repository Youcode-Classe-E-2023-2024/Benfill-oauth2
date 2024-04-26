<?php

namespace Database\Seeders;

use App\Models\PromoCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promoCode = [
            'reduction_code' => 'MO9AWIL100',
            'reduction_percentage' => 15
        ];

        PromoCode::create($promoCode);
    }
}

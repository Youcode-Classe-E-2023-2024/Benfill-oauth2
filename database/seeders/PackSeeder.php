<?php

namespace Database\Seeders;

use App\Models\Pack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packs = [
            [
                'pack_name' => 'standard',
                'pack_description' => 'Déléguez vos démarches de création à nos juristes expérimentés',
                'pack_price' => 999,
            ],
            [
                'pack_name' => 'Pro',
                'pack_description' => "Recevez votre Kbis plus rapidement et bénéficiez d'une assistance juriste",
                'pack_price' => 1999,
            ],
            [
                'pack_name' => 'Premium',
                'pack_description' => "La création Express de votre société vous est offerte avec l'abonnement annuel.",
                'pack_price' => 2999,
            ]
        ];

        foreach ($packs as $pack) {
            Pack::create($pack);
        }

    }
}

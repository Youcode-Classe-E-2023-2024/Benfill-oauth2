<?php

namespace Database\Seeders;

use App\Models\PackFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pack_1 = [
            [
                'feature' => 'Les statuts de votre société',
                'pack_id' => 1
            ],
            [
                'feature' => "Vérification de votre dossier d'immatriculation",
                'pack_id' => 1
            ],
            [
                'feature' => "Publication de l'annonce légale",
                'pack_id' => 1
            ],
            [
                'feature' => 'Immatriculation de votre société au greffe',
                'pack_id' => 1
            ],
            [
                'feature' => 'Garantie anti-rejet du greffe',
                'pack_id' => 1
            ]
        ];


        $pack_2 = [
            [
                'feature' => 'Les statuts de votre société',
                'pack_id' => 2
            ],
            [
                'feature' => "Vérification de votre dossier d'immatriculation",
                'pack_id' => 2
            ],
            [
                'feature' => "Publication de l'annonce légale",
                'pack_id' => 2
            ],
            [
                'feature' => 'Immatriculation de votre société au greffe',
                'pack_id' => 2
            ],
            [
                'feature' => 'Garantie anti-rejet du greffe',
                'pack_id' => 2
            ],

            [
                'feature' => 'Traitement express 24h',
                'pack_id' => 2
            ],
            [
                'feature' => 'Assistance juriste illimitée (téléphone, mail, whatsapp)',
                'pack_id' => 2
            ],
        ];


        $pack_3 = [
            [
                'feature' => 'Les statuts de votre société',
                'pack_id' => 3
            ],
            [
                'feature' => "Vérification de votre dossier d'immatriculation",
                'pack_id' => 3
            ],
            [
                'feature' => "Publication de l'annonce légale",
                'pack_id' => 3
            ],
            [
                'feature' => 'Immatriculation de votre société au greffe',
                'pack_id' => 3
            ],
            [
                'feature' => 'Garantie anti-rejet du greffe',
                'pack_id' => 3
            ],

            [
                'feature' => 'Traitement express 24h',
                'pack_id' => 3
            ],
            [
                'feature' => 'Assistance juriste illimitée (téléphone, mail, whatsapp)',
                'pack_id' => 3
            ],
            [
                'feature' => 'Rendez-vous comptable pour choisir la forme juridique optimale et les options fiscales les plus avantageuses',
                'pack_id' => 3
            ],
            [
                'feature' => 'Conformité Annuelle avec déclarations de TVA, bilan, liasse fiscale réalisés par votre comptable',
                'pack_id' => 3
            ],
            [
                'feature' => 'Logiciel comptable simple et intuitif pour vous faire gagner du temps',
                'pack_id' => 3
            ],
            [
                'feature' => 'Votre comptable réactif et accessible par chat, téléphone, visio et email',
                'pack_id' => 3
            ],
        ];

        $packs = [$pack_1, $pack_2, $pack_3];

        foreach ($packs as $features) {
            foreach ($features as $feature) {
                PackFeature::create($feature);
            }
        }

    }
}

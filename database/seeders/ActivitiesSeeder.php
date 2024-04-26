<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            "AGRICULTURE, SYLVICULTURE ET PÊCHE",
            "INDUSTRIES EXTRACTIVES",
            "INDUSTRIE MANUFACTURIÈRE",
            "PRODUCTION ET DISTRIBUTION D'ÉLECTRICITÉ, DE GAZ, DE VAPEUR ET D'AIR CONDITIONNÉ",
            "PRODUCTION ET DISTRIBUTION D'EAU",
            "ASSAINISSEMENT, GESTION DES DÉCHETS ET DÉPOLLUTION",
            "CONSTRUCTION",
            "COMMERCE",
            "RÉPARATION D'AUTOMOBILES ET DE MOTOCYCLES",
            "TRANSPORTS ET ENTREPOSAGE",
            "HÉBERGEMENT ET RESTAURATION",
            "INFORMATION ET COMMUNICATION",
            "ACTIVITÉS FINANCIÈRES ET D'ASSURANCE",
            "ACTIVITÉS IMMOBILIÈRES",
            "ACTIVITÉS SPÉCIALISÉES, SCIENTIFIQUES ET TECHNIQUES",
            "ACTIVITÉS DE SERVICES ADMINISTRATIFS ET DE SOUTIEN",
            "ADMINISTRATION PUBLIQUE",
            "ENSEIGNEMENT",
            "SANTÉ HUMAINE ET ACTION SOCIALE",
            "ARTS, SPECTACLES ET ACTIVITÉS RÉCRÉATIVES",
            "AUTRES ACTIVITÉS DE SERVICES",
            "ACTIVITÉS DES MÉNAGES EN TANT QU'EMPLOYEURS",
            "ACTIVITÉS INDIFFÉRENCIÉES DES MÉNAGES EN TANT QUE PRODUCTEURS DE BIENS ET SERVICES POUR USAGE PROPRE",
            "ACTIVITÉS EXTRA-TERRITORIALES"
        ];

        foreach ($activities as $activity) {
            Activity::create([
                'activity_name' => $activity]);
        }
    }
}

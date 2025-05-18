<?php

// Définition du circuit standard (circuit 1 par défaut)
$stages = [
    [
        'title' => 'Kyoto',
        'duration' => 4,
        'lodging_options' => [
            ['id' => 'ryokan1', 'name' => 'Ryokan traditionnel 5★'],
            ['id' => 'hotel1', 'name' => 'Hôtel moderne 4★'],
            ['id' => 'guesthouse1', 'name' => 'Maison d\'hôtes locale']
        ],
        'activities' => [
            ['id' => 'temple1', 'name' => 'Visite des temples'],
            ['id' => 'tea1', 'name' => 'Cérémonie du thé'],
            ['id' => 'garden1', 'name' => 'Jardins impériaux']
        ],
        'transport_options' => [
            ['id' => 'train1', 'name' => 'Train rapide'],
            ['id' => 'bus1', 'name' => 'Bus touristique']
        ]
    ],
    [
        'title' => 'Pékin',
        'duration' => 5,
        'lodging_options' => [
            ['id' => 'hotel2', 'name' => 'Hôtel 5★ près de la Cité Interdite'],
            ['id' => 'boutique1', 'name' => 'Hôtel boutique dans le quartier historique']
        ],
        'activities' => [
            ['id' => 'wall1', 'name' => 'Grande Muraille'],
            ['id' => 'palace1', 'name' => 'Cité Interdite'],
            ['id' => 'market1', 'name' => 'Marché de nuit']
        ],
        'transport_options' => [
            ['id' => 'plane1', 'name' => 'Vol direct'],
            ['id' => 'train2', 'name' => 'Train de nuit']
        ]
    ],
    [
        'title' => 'Agra',
        'duration' => 6,
        'lodging_options' => [
            ['id' => 'resort1', 'name' => 'Resort de luxe vue Taj Mahal'],
            ['id' => 'heritage1', 'name' => 'Hôtel patrimonial']
        ],
        'activities' => [
            ['id' => 'taj1', 'name' => 'Visite du Taj Mahal'],
            ['id' => 'fort1', 'name' => 'Fort Rouge'],
            ['id' => 'cooking1', 'name' => 'Cours de cuisine indienne']
        ],
        'transport_options' => [
            ['id' => 'car1', 'name' => 'Voiture privée'],
            ['id' => 'train3', 'name' => 'Train express']
        ]
    ]
];

// Définition des circuits supplémentaires pour différentes destinations
$circuits = [
    // Circuit 1 est déjà défini dans $stages (circuit par défaut)
    '1' => $stages,
    
    // Circuit 2 - Tour d'Europe
    '2' => [
        [
            'title' => 'Paris',
            'duration' => 3,
            'lodging_options' => [
                ['id' => 'hotel_paris_luxe', 'name' => 'Hôtel de luxe près des Champs-Élysées'],
                ['id' => 'hotel_paris_standard', 'name' => 'Hôtel standard au Quartier Latin']
            ],
            'activities' => [
                ['id' => 'eiffel', 'name' => 'Tour Eiffel'],
                ['id' => 'louvre', 'name' => 'Musée du Louvre'],
                ['id' => 'seine', 'name' => 'Croisière sur la Seine']
            ],
            'transport_options' => [
                ['id' => 'train_eu', 'name' => 'Train à grande vitesse'],
                ['id' => 'avion_eu', 'name' => 'Vol court-courrier']
            ]
        ],
        [
            'title' => 'Rome',
            'duration' => 4,
            'lodging_options' => [
                ['id' => 'hotel_rome_centre', 'name' => 'Hôtel au centre historique'],
                ['id' => 'villa_rome', 'name' => 'Villa privée']
            ],
            'activities' => [
                ['id' => 'colisee', 'name' => 'Visite du Colisée'],
                ['id' => 'vatican', 'name' => 'Visite du Vatican'],
                ['id' => 'pasta', 'name' => 'Cours de cuisine italienne']
            ],
            'transport_options' => [
                ['id' => 'train_eu2', 'name' => 'Train inter-cité'],
                ['id' => 'ferry_eu', 'name' => 'Ferry méditerranéen']
            ]
        ],
        [
            'title' => 'Athènes',
            'duration' => 3,
            'lodging_options' => [
                ['id' => 'resort_athenes', 'name' => 'Resort vue Acropole'],
                ['id' => 'hotel_athenes', 'name' => 'Hôtel standard']
            ],
            'activities' => [
                ['id' => 'acropole', 'name' => 'Visite de l\'Acropole'],
                ['id' => 'musee_athenes', 'name' => 'Musée archéologique'],
                ['id' => 'plaka', 'name' => 'Balade dans Plaka']
            ],
            'transport_options' => [
                ['id' => 'avion_eu2', 'name' => 'Vol retour'],
                ['id' => 'bus_eu', 'name' => 'Bus panoramique']
            ]
        ]
    ],
    
    // Circuit 5 - Mexique
    '5' => [
        [
            'title' => 'Chichen Itza',
            'duration' => 3,
            'lodging_options' => [
                ['id' => 'boutique1', 'name' => 'Hôtel-boutique colonial 5★'],
                ['id' => 'hacienda1', 'name' => 'Hacienda de luxe'],
                ['id' => 'hotel1', 'name' => 'Hôtel standard 4★']
            ],
            'activities' => [
                ['id' => 'pyramid1', 'name' => 'Visite nocturne de Kukulcán'],
                ['id' => 'cenote1', 'name' => 'Baignade dans le cénote sacré'],
                ['id' => 'cooking1', 'name' => 'Cours de cuisine yucatèque']
            ],
            'transport_options' => [
                ['id' => 'bus1', 'name' => 'Bus climatisé privé'],
                ['id' => 'van1', 'name' => 'Minivan avec guide']
            ]
        ],
        [
            'title' => 'Uxmal',
            'duration' => 3,
            'lodging_options' => [
                ['id' => 'hacienda2', 'name' => 'Hacienda historique restaurée'],
                ['id' => 'lodge1', 'name' => 'Lodge de charme'],
                ['id' => 'hotel2', 'name' => 'Hôtel colonial']
            ],
            'activities' => [
                ['id' => 'arch1', 'name' => 'Site archéologique d\'Uxmal'],
                ['id' => 'village1', 'name' => 'Visite d\'un village maya'],
                ['id' => 'craft1', 'name' => 'Atelier artisanat local']
            ],
            'transport_options' => [
                ['id' => 'bus2', 'name' => 'Bus de luxe'],
                ['id' => 'car1', 'name' => 'Voiture privée avec chauffeur']
            ]
        ],
        [
            'title' => 'Palenque',
            'duration' => 3,
            'lodging_options' => [
                ['id' => 'ecolodge1', 'name' => 'Éco-lodge de luxe'],
                ['id' => 'jungle1', 'name' => 'Lodge dans la jungle'],
                ['id' => 'resort1', 'name' => 'Resort spa']
            ],
            'activities' => [
                ['id' => 'ruins1', 'name' => 'Exploration des ruines'],
                ['id' => 'jungle2', 'name' => 'Randonnée dans la jungle'],
                ['id' => 'waterfall1', 'name' => 'Cascades d\'Agua Azul']
            ],
            'transport_options' => [
                ['id' => 'plane1', 'name' => 'Vol domestique'],
                ['id' => 'bus3', 'name' => 'Bus de nuit confort']
            ]
        ],
        [
            'title' => 'Tulum',
            'duration' => 4,
            'lodging_options' => [
                ['id' => 'beach1', 'name' => 'Resort plage 5★'],
                ['id' => 'boutique2', 'name' => 'Hôtel-boutique écologique'],
                ['id' => 'villa1', 'name' => 'Villa privée']
            ],
            'activities' => [
                ['id' => 'ruins2', 'name' => 'Site archéologique de Tulum'],
                ['id' => 'snorkel1', 'name' => 'Snorkeling dans les cénotes'],
                ['id' => 'beach2', 'name' => 'Journée plage privée']
            ],
            'transport_options' => [
                ['id' => 'shuttle1', 'name' => 'Navette privée'],
                ['id' => 'car2', 'name' => 'Location de voiture']
            ]
        ]
    ],
    
    // Définir d'autres circuits selon les besoins...
    '3' => [
        [
            'title' => 'Safari Masai Mara',
            'duration' => 3,
            'lodging_options' => [
                ['id' => 'tent_luxury', 'name' => 'Tente de luxe'],
                ['id' => 'lodge_safari', 'name' => 'Lodge Safari']
            ],
            'activities' => [
                ['id' => 'safari_morning', 'name' => 'Safari matinal'],
                ['id' => 'safari_night', 'name' => 'Safari nocturne'],
                ['id' => 'masai_village', 'name' => 'Visite village Masai']
            ],
            'transport_options' => [
                ['id' => 'jeep', 'name' => 'Jeep Safari'],
                ['id' => 'avion_safari', 'name' => 'Avion léger']
            ]
        ],
        [
            'title' => 'Zanzibar',
            'duration' => 4,
            'lodging_options' => [
                ['id' => 'beach_resort', 'name' => 'Resort de plage'],
                ['id' => 'villa_zanzibar', 'name' => 'Villa privée']
            ],
            'activities' => [
                ['id' => 'stone_town', 'name' => 'Visite de Stone Town'],
                ['id' => 'snorkeling', 'name' => 'Snorkeling récifs coralliens'],
                ['id' => 'spice_tour', 'name' => 'Tour des épices']
            ],
            'transport_options' => [
                ['id' => 'ferry_zanzibar', 'name' => 'Ferry'],
                ['id' => 'avion_zanzibar', 'name' => 'Vol national']
            ]
        ]
    ],
    
    // Circuit 7 - Tour d'Asie
    '7' => [
        [
            'title' => 'Tokyo',
            'duration' => 4,
            'lodging_options' => [
                ['id' => 'hotel_tokyo_luxe', 'name' => 'Hôtel de luxe à Shinjuku'],
                ['id' => 'hotel_tokyo_trad', 'name' => 'Ryokan traditionnel'],
                ['id' => 'hotel_tokyo_business', 'name' => 'Hôtel d\'affaires moderne']
            ],
            'activities' => [
                ['id' => 'tokyo_tower', 'name' => 'Tokyo Tower & Skytree'],
                ['id' => 'sumo', 'name' => 'Tournoi de Sumo'],
                ['id' => 'harajuku', 'name' => 'Shopping à Harajuku']
            ],
            'transport_options' => [
                ['id' => 'shinkansen', 'name' => 'Train Shinkansen'],
                ['id' => 'avion_tokyo', 'name' => 'Vol domestique']
            ]
        ],
        [
            'title' => 'Hong Kong',
            'duration' => 3,
            'lodging_options' => [
                ['id' => 'hotel_hk_luxe', 'name' => 'Grand hôtel vue sur la baie'],
                ['id' => 'hotel_hk_boutique', 'name' => 'Hôtel boutique à Central'],
                ['id' => 'hotel_hk_kowloon', 'name' => 'Hôtel standard à Kowloon']
            ],
            'activities' => [
                ['id' => 'peak_tram', 'name' => 'Victoria Peak & Tram'],
                ['id' => 'harbour', 'name' => 'Croisière dans le port'],
                ['id' => 'markets', 'name' => 'Marchés nocturnes']
            ],
            'transport_options' => [
                ['id' => 'ferry_hk', 'name' => 'Ferry rapide'],
                ['id' => 'vol_hk', 'name' => 'Vol international']
            ]
        ],
        [
            'title' => 'Singapour',
            'duration' => 3,
            'lodging_options' => [
                ['id' => 'mbs', 'name' => 'Marina Bay Sands'],
                ['id' => 'hotel_sg_orchard', 'name' => 'Hôtel sur Orchard Road'],
                ['id' => 'hotel_sg_colonial', 'name' => 'Hôtel colonial Raffles']
            ],
            'activities' => [
                ['id' => 'gardens', 'name' => 'Gardens by the Bay'],
                ['id' => 'sentosa', 'name' => 'Île de Sentosa'],
                ['id' => 'food_tour', 'name' => 'Tour gastronomique hawkers']
            ],
            'transport_options' => [
                ['id' => 'vol_sg', 'name' => 'Vol international'],
                ['id' => 'croisiere_sg', 'name' => 'Croisière de luxe']
            ]
        ],
        [
            'title' => 'Bali',
            'duration' => 5,
            'lodging_options' => [
                ['id' => 'villa_bali', 'name' => 'Villa privée avec piscine'],
                ['id' => 'resort_bali', 'name' => 'Resort de plage 5★'],
                ['id' => 'ubud_retreat', 'name' => 'Retraite à Ubud']
            ],
            'activities' => [
                ['id' => 'temples_bali', 'name' => 'Temples sacrés'],
                ['id' => 'surf', 'name' => 'Cours de surf'],
                ['id' => 'spa', 'name' => 'Journée spa balinais']
            ],
            'transport_options' => [
                ['id' => 'vol_retour', 'name' => 'Vol international retour'],
                ['id' => 'yacht', 'name' => 'Yacht privé inter-îles']
            ]
        ]
    ]
];

// Si on est dans l'API, on ne fait rien de plus car les données seront utilisées directement
// Si on est dans un include normal, on laisse les données disponibles pour le script appelant
?>

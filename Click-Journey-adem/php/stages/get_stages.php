<?php
// Simulation de données pour les étapes du voyage
// Dans une vraie application, ces données viendraient d'une base de données
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
?>

<?php

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


$circuits[5] = [
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
];
?>

<?php
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $voyages = readCSV('../data/voyages.csv');
    
    $keyword = isset($_GET['destination']) ? strtolower($_GET['destination']) : '';
    if ($keyword) {
        $voyages = array_filter($voyages, function($voyage) use ($keyword) {
            return strpos(strtolower($voyage['titre']), $keyword) !== false ||
                   strpos(strtolower($voyage['description']), $keyword) !== false;
        });
    }
    
    if (isset($_GET['transport']) && !empty($_GET['transport'])) {
        $transport = strtolower($_GET['transport']);
        $voyages = array_filter($voyages, function($voyage) use ($transport) {
            return strpos(strtolower($voyage['transport']), $transport) !== false;
        });
    }
    
    if (isset($_GET['prix']) && !empty($_GET['prix'])) {
        $prixRange = explode('-', $_GET['prix']);
        $voyages = array_filter($voyages, function($voyage) use ($prixRange) {
            $prix = (int)$voyage['prix'];
            if (count($prixRange) === 2) {
                $min = (int)$prixRange[0];
                $max = (int)$prixRange[1];
                return $prix >= $min && $prix <= $max;
            } elseif ($_GET['prix'] === '2000+') {
                return $prix >= 2000;
            }
            return true;
        });
    }
    
    if (isset($_GET['date-depart']) && !empty($_GET['date-depart'])) {
        $dateDepart = $_GET['date-depart'];
        $voyages = array_filter($voyages, function($voyage) use ($dateDepart) {
            return strtotime($voyage['date_ajout']) <= strtotime($dateDepart);
        });
    }
    
    if (isset($_GET['personnes']) && !empty($_GET['personnes'])) {
        $personnes = (int)$_GET['personnes'];
    }
    
    if (isset($_GET['duree']) && !empty($_GET['duree'])) {
        $duree = $_GET['duree'];
        $voyages = array_filter($voyages, function($voyage) use ($duree) {
            $jours = (int)$voyage['duree'];
            switch($duree) {
                case 'weekend':
                    return $jours <= 3;
                case 'semaine':
                    return $jours > 3 && $jours <= 7;
                case 'quinzaine':
                    return $jours > 7 && $jours <= 14;
                case 'mois':
                    return $jours > 14;
                default:
                    return true;
            }
        });
    }
    
    header('Content-Type: application/json');
    echo json_encode(array_values($voyages));
}
?>

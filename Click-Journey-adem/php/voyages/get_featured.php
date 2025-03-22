<?php
require_once '../includes/functions.php';

$voyages = readCSV('../data/voyages.csv');

// Trier par note décroissante
usort($voyages, function($a, $b) {
    return $b['note'] <=> $a['note'];
});

// Prendre les 2 voyages les mieux notés
$best_rated = array_slice($voyages, 0, 2);

// Trier par date d'ajout décroissante
usort($voyages, function($a, $b) {
    return strtotime($b['date_ajout']) <=> strtotime($a['date_ajout']);
});

// Prendre le voyage le plus récent
$newest = array_slice($voyages, 0, 1);

// Combiner les résultats
$featured_voyages = array_merge($best_rated, $newest);

// Supprimer les doublons éventuels
$featured_voyages = array_unique($featured_voyages, SORT_REGULAR);

header('Content-Type: application/json');
echo json_encode($featured_voyages);
?>

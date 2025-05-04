<?php
require_once '../includes/functions.php';

$voyages = readCSV('../data/voyages.csv');

usort($voyages, function($a, $b) {
    return $b['note'] <=> $a['note'];
});

$best_rated = array_slice($voyages, 0, 2);

usort($voyages, function($a, $b) {
    return strtotime($b['date_ajout']) <=> strtotime($a['date_ajout']);
});

$newest = array_slice($voyages, 0, 1);

$featured_voyages = array_merge($best_rated, $newest);
$featured_voyages = array_unique($featured_voyages, SORT_REGULAR);

header('Content-Type: application/json');
echo json_encode($featured_voyages);
?>

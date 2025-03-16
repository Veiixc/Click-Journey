<?php
require_once '../includes/functions.php';

// Récupérer tous les voyages



$voyages = readCSV('../data/voyages.csv');




// Mélanger aléatoirement les voyages
shuffle($voyages);




// Prendre les 3 premiers voyages
$featured_voyages = array_slice($voyages, 0, 3);


header('Content-Type: application/json');
echo json_encode($featured_voyages);
?>

<?php
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $voyages = readCSV('../data/voyages.csv');



    
    $keyword = isset($_GET['keyword']) ? strtolower($_GET['keyword']) : '';
    
    if ($keyword) {




        $voyages = array_filter($voyages, function($voyage) use ($keyword) {
            return strpos(strtolower($voyage['titre']), $keyword) !== false ||
                   strpos(strtolower($voyage['description']), $keyword) !== false;
        });
    }











    
    header('Content-Type: application/json');
    echo json_encode(array_values($voyages));
}
?>

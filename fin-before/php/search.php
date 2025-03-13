<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $keyword = $_GET['keyword'];

    $voyages = json_decode(file_get_contents('../data/voyages.json'), true);
    $results = array_filter($voyages, function($voyage) use ($keyword) {
        return stripos($voyage['title'], $keyword) !== false;
    });

    if (count($results) > 0) {
        foreach ($results as $voyage) {
            echo "id: " . $voyage["id"] . " - Title: " . $voyage["title"] . " - Price: " . $voyage["total_price"] . "<br>";
        }
    } else {
        echo "0 results";
    }
}
?>

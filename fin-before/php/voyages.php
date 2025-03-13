<?php
include 'database.php';

$voyages = json_decode(file_get_contents('../data/voyages.json'), true);

foreach ($voyages as $voyage) {
    echo "id: " . $voyage["id"] . " - Title: " . $voyage["title"] . " - Price: " . $voyage["total_price"] . "<br>";
}
?>

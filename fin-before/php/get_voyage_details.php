<?php
require_once 'database.php';

if (isset($_GET['id'])) {
    $voyages = readVoyages();
    $voyage_id = (int)$_GET['id'];
    
    foreach ($voyages as $voyage) {
        if ($voyage['id'] === $voyage_id) {
            header('Content-Type: application/json');
            echo json_encode($voyage);
            exit();
        }
    }
}

http_response_code(404);
echo json_encode(['error' => 'Voyage non trouvé']);
?>

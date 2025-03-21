<?php
function readCSV($filename) {
    $rows = array();
    if (($handle = fopen($filename, "r")) !== FALSE) {
        // Skip the first line if it starts with //
        $firstLine = fgets($handle);
        if (strpos($firstLine, '//') !== 0) {
            // If it's not a comment, reset pointer to start
            rewind($handle);
        }
        
        $headers = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== FALSE) {
            if (count($headers) === count($data)) {
                $rows[] = array_combine($headers, $data);
            }
        }
        fclose($handle);
    }
    error_log('CSV Data read: ' . print_r($rows, true));
    return $rows;
}
function writeCSV($filename, $data, $headers) {
    $fp = fopen($filename, 'w');
    fputcsv($fp, $headers);
    foreach ($data as $row) {
        fputcsv($fp, $row);
    }
    fclose($fp);
    return true; // Ajouté pour confirmer que l'écriture s'est bien déroulée
}
function checkAuth() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /Click-Journey-adem/html/connexion.php');
        exit();
    }
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
?>

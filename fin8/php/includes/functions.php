<?php
function readCSV($filename) {
    $rows = array();
    if (($handle = fopen($filename, "r")) !== FALSE) {
        $headers = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== FALSE) {
            $rows[] = array_combine($headers, $data);
        }
        fclose($handle);
    }
    return $rows;
}
function writeCSV($filename, $data, $headers) {
    $fp = fopen($filename, 'w');
    fputcsv($fp, $headers);
    foreach ($data as $row) {
        fputcsv($fp, $row);
    }





    
    fclose($fp);
}
function checkAuth() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /fin2/html/connexion.php');
        exit();
    }
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
?>

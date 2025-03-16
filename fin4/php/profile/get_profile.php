<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit();
}

$profileData = [
    'nom' => $_SESSION['nom'],
    'prenom' => $_SESSION['prenom'],
    'email' => $_SESSION['email'],
    'date_naissance' => $_SESSION['date_naissance'],
    'nom_complet' => $_SESSION['prenom'] . ' ' . $_SESSION['nom']
];

header('Content-Type: application/json');
echo json_encode($profileData);
?>

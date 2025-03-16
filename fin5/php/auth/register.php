<?php
session_start();
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = readCSV('../data/users.csv');
    
    // Vérifie si le login existe déjà
    foreach ($users as $user) {
        if ($user['login'] === $_POST['login']) {
            echo json_encode(['success' => false, 'message' => 'Ce login existe déjà']);
            exit();
        }
    }
    
    $newUser = array(
        'login' => $_POST['login'],
        'password' => $_POST['password'], // Stockage en clair pour les tests
        'role' => 'user',
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'date_naissance' => $_POST['date_naissance'],
        'email' => $_POST['email'],
        'date_inscription' => date('Y-m-d')
    );
    
    $users[] = $newUser;
    
    // Utilise les en-têtes existants du fichier CSV
    $headers = array('login', 'password', 'role', 'nom', 'prenom', 'date_naissance', 'email', 'date_inscription');
    
    writeCSV('../data/users.csv', $users, $headers);
    
    echo json_encode(['success' => true]);
    exit();
}
?>

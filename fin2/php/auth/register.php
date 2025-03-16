<?php
session_start();
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = readCSV('../data/users.csv');
    
    $newUser = array(
        'login' => $_POST['login'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role' => 'user',
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'date_naissance' => $_POST['date_naissance'],
        'email' => $_POST['email'],
        'date_inscription' => date('Y-m-d')
    );
    
    $users[] = $newUser;
    $headers = array_keys($newUser);
    
    writeCSV('../data/users.csv', $users, $headers);
    
    header('Location: /fin2/html/connexion.html?success=1');
    exit();
}
?>

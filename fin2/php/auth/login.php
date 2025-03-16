<?php
session_start();
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = readCSV('../data/users.csv');
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    foreach ($users as $user) {
        if ($user['login'] === $login && $user['password'] === $password) {  // Comparaison directe
            $_SESSION['user_id'] = $login;
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['nom'] = $user['nom'];
            
            echo json_encode(['success' => true, 'role' => $user['role']]);
            exit();
        }
    }
    
    echo json_encode(['success' => false, 'message' => 'Login ou mot de passe incorrect']);
    exit();
}
?>

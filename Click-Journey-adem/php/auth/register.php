<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et validation des champs requis
    $required_fields = ['login', 'password', 'nom', 'prenom', 'date_naissance', 'email'];
    $data = [];
    foreach ($required_fields as $field) {
        $data[$field] = trim($_POST[$field] ?? '');
        if (empty($data[$field])) {
            echo "Erreur : Tous les champs doivent être remplis";
            exit();
        }
    }
    
    $csvPath = __DIR__ . '/../data/users.csv';
    if (!file_exists($csvPath)) {
        echo "Erreur : Fichier d'utilisateurs introuvable";
        exit();
    }
    
    // Vérifier si le login existe déjà
    $users = readCSV($csvPath);
    foreach ($users as $user) {
        if ($user['login'] === $data['login']) {
            echo "Erreur : Ce login existe déjà";
            exit();
        }
    }
    
    // Création du nouvel utilisateur (role par défaut : user)
    $newUser = [
        'login' => $data['login'],
        'password' => $data['password'],
        'role' => 'user',
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'date_naissance' => $data['date_naissance'],
        'email' => $data['email'],
        'date_inscription' => date('Y-m-d')
    ];
    
    $users[] = $newUser;
    $headers = ['login', 'password', 'role', 'nom', 'prenom', 'date_naissance', 'email', 'date_inscription'];
    
    if (writeCSV($csvPath, $users, $headers)) {
        // Auto-connexion après inscription
        $_SESSION['user_id'] = $newUser['login'];
        $_SESSION['user_role'] = $newUser['role'];
        $_SESSION['nom'] = $newUser['nom'];
        $_SESSION['prenom'] = $newUser['prenom'];
        $_SESSION['email'] = $newUser['email'];
        $_SESSION['date_naissance'] = $newUser['date_naissance'];
        
        echo "Réussi : Inscription réussie, vous êtes connecté";
        exit();
    } else {
        echo "Erreur : Problème lors de l'inscription";
        exit();
    }
} else {
    echo "Erreur : Requête invalide";
}
?>

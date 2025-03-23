<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = trim($_POST['password'] ?? '');
    





    if (empty($login) || empty($password)) {
        $_SESSION['error'] = "Tous les champs doivent être remplis";
        header('Location: /Click-Journey-adem/html/connexion.php');
        exit();
    }
    
    $csvPath = __DIR__ . '/../data/users.csv';
    if (!file_exists($csvPath)) {
     echo "Erreur : Fichier d'utilisateurs introuvable";
exit();
    }
    
    $users = readCSV($csvPath);
    $userFound = false;





    foreach ($users as $user) {



        if ($user['login'] === $login) {
            $userFound = $user;
            break;
        }
    }
    
    if (!$userFound) {
        $_SESSION['error'] = "Login ou mot de passe incorrect !!";


        header('Location: /Click-Journey-adem/html/connexion.php');
        exit();
    }
    
    if ($userFound['password'] !== $password) {



 $_SESSION['error'] = "Login ou mot de passe incorrect";
header('Location: /Click-Journey-adem/html/connexion.php');
        exit();
    }
    
    // Connexion réussie : initialisation de la session
    $_SESSION['user_id'] = $userFound['login'];


    $_SESSION['user_role'] = $userFound['role'];


    $_SESSION['nom'] = $userFound['nom'];


    $_SESSION['prenom'] = $userFound['prenom'];



    $_SESSION['email'] = $userFound['email'];



    $_SESSION['date_naissance'] = $userFound['date_naissance'];
    $_SESSION['telephone'] = $userFound['telephone'];
    
    $_SESSION['success'] = "Bienvenue " . $userFound['prenom'] . " " . $userFound['nom'] . " !";



    header('Location: /Click-Journey-adem/html/profil.php');
    exit();
} else {
    
    
    header('Location: /Click-Journey-adem/html/connexion.php');
    exit();
}
?>

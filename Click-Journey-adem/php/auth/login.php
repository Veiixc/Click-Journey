<?php
// Initialisation de la session et chargement des fonctions
session_start(); // Démarre la session pour gérer les données utilisateur
require_once   __DIR__ . '/../includes/functions.php'; // Importe les fonctions utilitaires

// Traitement du formulaire de connexion
if (  $_SERVER['REQUEST_METHOD'] === 'POST') { // Vérifie si le formulaire a été soumis


    $login =   trim($_POST['login'] ?? ''); // Récupère et nettoie le login
    $password =    trim($_POST['password'] ?? ''); // Récupère et nettoie le mot de passe



    if (empty($login)   || empty(  $password)) { // Vérifie que les champs ne sont pas vides
        
        
        $_SESSION['error']   = "Veuillez remplir tous les champs"; // Message d'erreur
        header('Location: /Click-Journey-adem/html/connexion.php'); // Redirige vers la page de connexion
        exit(   ); // Arrête l'exécution du script
    }
    
    $csvPath = __DIR__ .  '/../data/users.csv'; // Chemin vers le fichier des utilisateurs
    if (!file_exists($csvPath)) { // Vérifie si le fichier existe



        $_SESSION['error'] = "Erreur système. Veuillez réessayer plus tard."; // Message d'erreur système
        header(  'Location: /Click-Journey-adem/html/connexion.php'); // Redirige vers la connexion
        exit();
    }
    
    $users = readCSV($csvPath); // Lit les données utilisateurs depuis le CSV
    $userFound =   false; // Initialise la variable de recherche utilisateur


    foreach ( $users as $user) { // Parcourt tous les utilisateurs
        if (  $user['login'] === $login  && $user['password'] === $password) { // Vérifie si login et mot de passe correspondent
            if ($user['role'] === 'banned') { // Vérifie si l'utilisateur est banni
                $_SESSION['error'] = "Votre compte a été banni. Vous ne pouvez plus vous connecter."; // Message d'erreur pour utilisateur banni
                header('Location: /Click-Journey-adem/html/connexion.php'); // Redirige vers la page de connexion
                exit(); // Arrête l'exécution du script
            }
            
            $userFound =  $user; // Stocke les données de l'utilisateur trouvé
            break; // Sort de la boucle une fois l'utilisateur trouvé
        }
    }
    
    if ( !$userFound) { // Si aucun utilisateur n'a été trouvé
        // Échec de l'authentification
        
        
        $_SESSION['error'] = "Login ou mot de passe incorrect"; // Message d'erreur d'authentification
        header(  'Location: /Click-Journey-adem/html/connexion.php'  ); // Redirige vers la connexion
        exit(); // Arrêt du script
    }
    
    $_SESSION['user_id']  = $userFound['login']; // Enregistre l'ID utilisateur en session
    $_SESSION['user_role'] =  $userFound['role']; // Enregistre le rôle utilisateur en session



    $_SESSION['nom'] =    $userFound['nom']; // Stocke le nom en session
    $_SESSION['prenom'] = $userFound['prenom']; // Stocke le prénom en session




    $_SESSION['email'] = $userFound['email']; // Stocke l'email en session
    $_SESSION['date_naissance'] = $userFound[  'date_naissance'  ]; // Stocke la date de naissance en session
    $_SESSION['telephone'] = $userFound['telephone']; // Stocke le téléphone en session
    
    if (isset($_COOKIE['saved_cart'])) { // Vérifie si un panier est sauvegardé dans un cookie
        $saved_cart = json_decode($_COOKIE['saved_cart'], true); // Décode le panier JSON
        if (is_array($saved_cart) && !empty($saved_cart)) { // Vérifie que le panier est valide
            $_SESSION['cart'] = $saved_cart; // Restaure le panier en session
            
            setcookie('saved_cart', '', time() - 3600, '/'); // Supprime le cookie après restauration
        }
    }
    
    $_SESSION['success'] = "Bienvenue " . $userFound['prenom'] . " " . $userFound['nom']   . " !"; // Message de bienvenue
    
    
    header('Location: /Click-Journey-adem/html/profil.php'); // Redirige vers la page de profil
    exit(   ); // Arrête l'exécution du script
} else { // Si la page est accédée directement (sans POST)


    header( 'Location: /Click-Journey-adem/html/connexion.php'  ); // Redirige vers la page de connexion



    exit();
}
?>

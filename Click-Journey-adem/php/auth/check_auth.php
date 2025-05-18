<?php
// Initialisation de la session utilisateur
session_start(); // Démarre ou reprend une session existante


/**
 * Vérifie si un utilisateur est actuellement connecté
 * @return bool Vrai si l'utilisateur est connecté, faux sinon
 */
function isLoggedIn() { // Vérifie si l'utilisateur est connecté

    // Vérifie la présence d'un ID utilisateur valide dans la session
    return isset($_SESSION['user_id'])      && !empty($_SESSION['user_id']); // Renvoie vrai si l'ID utilisateur existe et n'est pas vide
}


/**
 * Force la connexion pour accéder à une page protégée
 * Redirige vers la page de connexion si l'utilisateur n'est pas connecté
 */
function requireLogin() { // Force la connexion pour accéder à une page protégée



    if (!isLoggedIn()) { // Si l'utilisateur n'est pas connecté
    $_SESSION['error']  =     'Veuillez vous connecter pour accéder à cette page'; // Message d'erreur dans la session
        header('Location: /Click-Journey-adem/html/connexion.php'); // Redirection vers la page de connexion
        exit(); // Arrête l'exécution du script
    }
}

function redirectIfLoggedIn() { // Redirige si déjà connecté
    if (isLoggedIn()) { // Si l'utilisateur est déjà connecté


header('Location: /Click-Journey-adem/html/profil.php'); // Redirection vers la page de profil
        exit(

        ); // Arrête l'exécution du script
    }
}


function requireAdmin() { // Vérifie si l'utilisateur est administrateur
    requireLogin(); // D'abord, vérifie qu'il est connecté



    if ($_SESSION['user_role']   !==    'admin') { // Si l'utilisateur n'a pas le rôle admin
header('Location: /Click-Journey-adem/html/profil.php'); // Redirection vers la page profil standard

        exit(); // Arrête l'exécution du script
    }
}
?>

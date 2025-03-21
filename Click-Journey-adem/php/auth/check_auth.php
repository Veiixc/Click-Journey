<?php
session_start();

// Vérifie si l'utilisateur est connecté
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Force la connexion pour accéder à une page
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = 'Veuillez vous connecter pour accéder à cette page';
        header('Location: /Click-Journey-adem/html/connexion.php');
        exit();
    }
}

// Redirige l'utilisateur connecté vers sa page appropriée
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header('Location: /Click-Journey-adem/html/profil.php');
        exit();
    }
}

// Vérifie si l'utilisateur est admin
function requireAdmin() {
    requireLogin();
    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: /Click-Journey-adem/html/profil.php');
        exit();
    }
}
?>

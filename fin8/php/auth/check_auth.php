<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /fin2/html/connexion.php');
        exit();
    }
}

function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        if ($_SESSION['user_role'] === 'admin') {
            header('Location: /fin2/html/administrateur.php');
        } else {
            header('Location: /fin2/html/profil.php'); 
        }
        exit();
    }
}
?>

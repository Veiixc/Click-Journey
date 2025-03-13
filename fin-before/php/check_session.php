<?php
session_start();

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /fin/connexion.html');
        exit();
    }
}

function requireAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: /fin/connexion.html');
        exit();
    }
}

function redirectIfLoggedIn() {
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['role'] === 'admin') {
            header('Location: /fin/administrateur.html');
        } else {
            header('Location: /fin/index.php');
        }
        exit();
    }
}
?>

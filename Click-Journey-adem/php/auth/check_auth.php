<?php
session_start();


function isLoggedIn() {

    
    return isset($_SESSION['user_id'])      && !empty($_SESSION['user_id']);
}


function requireLogin() {



    if (!isLoggedIn()) {
    $_SESSION['error']  =     'Veuillez vous connecter pour accéder à cette page';
        header('Location: /Click-Journey-adem/html/connexion.php');
        exit();
    }
}

function redirectIfLoggedIn() {
    if (isLoggedIn()) {


header('Location: /Click-Journey-adem/html/profil.php');
        exit(

        );
    }
}


function requireAdmin() {
    requireLogin();



    if ($_SESSION['user_role']   !==    'admin') {
header('Location: /Click-Journey-adem/html/profil.php');

        exit();
    }
}
?>

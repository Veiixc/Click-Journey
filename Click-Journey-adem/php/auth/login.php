<?php
session_start();
require_once   __DIR__ . '/../includes/functions.php';

if (  $_SERVER['REQUEST_METHOD'] === 'POST') {


    $login =   trim($_POST['login'] ?? '');
    $password =    trim($_POST['password'] ?? '');



    if (empty($login)   || empty(  $password)) {
        
        
        $_SESSION['error']   = "Veuillez remplir tous les champs";
        header('Location: /Click-Journey-adem/html/connexion.php');
        exit(   );
    }
    
    $csvPath = __DIR__ .  '/../data/users.csv';
    if (!file_exists($csvPath)) {



        $_SESSION['error'] = "Erreur système. Veuillez réessayer plus tard.";
        header(  'Location: /Click-Journey-adem/html/connexion.php');
        exit();
    }
    
    $users = readCSV($csvPath);
    $userFound =   false;


    foreach ( $users as $user) {
        if (  $user['login'] === $login  && $user['password'] === $password) {
            
            
            $userFound =  $user;
            break;
        }
    }
    
    if ( !$userFound) {
        
        
        
        $_SESSION['error'] = "Login ou mot de passe incorrect";
        header(  'Location: /Click-Journey-adem/html/connexion.php'  );
        exit();
    }
    
    $_SESSION['user_id']  = $userFound['login'];
    $_SESSION['user_role'] =  $userFound['role'];



    $_SESSION['nom'] =    $userFound['nom'];
    $_SESSION['prenom'] = $userFound['prenom'];




    $_SESSION['email'] = $userFound['email'];
    $_SESSION['date_naissance'] = $userFound[  'date_naissance'  ];
    $_SESSION['telephone'] = $userFound['telephone'];
    
    if (isset($_COOKIE['saved_cart'])) {
        $saved_cart = json_decode($_COOKIE['saved_cart'], true);
        if (is_array($saved_cart) && !empty($saved_cart)) {
            $_SESSION['cart'] = $saved_cart;
            
            setcookie('saved_cart', '', time() - 3600, '/');
        }
    }
    
    $_SESSION['success'] = "Bienvenue " . $userFound['prenom'] . " " . $userFound['nom']   . " !";
    
    
    header('Location: /Click-Journey-adem/html/profil.php');
    exit(   );
} else {


    header( 'Location: /Click-Journey-adem/html/connexion.php'  );



    exit();
}
?>

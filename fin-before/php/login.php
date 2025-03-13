<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    $users = readUsers();
    array_shift($users); // Enlever l'en-tête
    
    foreach ($users as $user) {
        if ($user[0] === $login && password_verify($password, $user[1])) {
            $_SESSION['user_id'] = $user[0];
            $_SESSION['role'] = $user[2];
            $_SESSION['name'] = $user[3];
            
            if ($user[2] === 'admin') {
                header("Location: ../administrateur.html");
            } else {
                header("Location: ../index.php");
            }
            exit();
        }
    }
    
    header("Location: ../connexion.html?error=1");
    exit();
}
?>

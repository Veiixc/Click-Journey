<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'normal';
    $name = $_POST['nom']; // changé pour correspondre au formulaire
    $pseudo = $_POST['prenom']; // changé pour correspondre au formulaire
    $birthdate = $_POST['date_naissance']; // changé pour correspondre au formulaire
    $address = $_POST['Adresse']; // changé pour correspondre au formulaire
    $registration_date = date("Y-m-d H:i:s");

    if (empty($login) || empty($password) || empty($name) || empty($pseudo) || empty($birthdate) || empty($address)) {
        echo "<script>alert('Tous les champs sont requis'); window.history.back();</script>";
        exit();
    }

    // Lire les utilisateurs existants
    $users = readUsers();
    
    // Ajouter le nouvel utilisateur
    $newUser = [$login, $password, $role, $name, $pseudo, $birthdate, $address, $registration_date];
    $users[] = $newUser;
    
    // Écrire dans le fichier CSV
    writeUsers($users);

    echo "<script>alert('Inscription réussie!'); window.location.href='../connexion.html';</script>";
    exit();
}
?>

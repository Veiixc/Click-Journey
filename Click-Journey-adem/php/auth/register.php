<?php
session_start(); // Démarre la session pour gérer les données utilisateur
require_once __DIR__ . '/../includes/functions.php'; // Importe les fonctions utilitaires

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Vérifie si le formulaire a été soumis


    
    $required_fields = ['login', 'password', 'nom', 'prenom', 'date_naissance', 'email', 'telephone']; // Liste des champs obligatoires
    $data = []; // Initialise le tableau de données



    foreach ($required_fields as $field) { // Parcourt tous les champs obligatoires
        $data[$field] = trim($_POST[$field] ?? ''); // Récupère et nettoie chaque champ



        
        if (empty($data[$field])) { // Vérifie si un champ est vide
            
            
            
            
            $_SESSION['error'] = "Tous les champs sont requis"; // Message d'erreur
 header('Location: /Click-Journey-adem/html/inscription.php'); // Redirige vers la page d'inscription
            exit();
        }
    }
    
    $csvPath = __DIR__ . '/../data/users.csv'; // Chemin vers le fichier des utilisateurs
    if (!file_exists($csvPath)) { // Vérifie si le fichier existe
        $_SESSION['error'] = "Erreur système. Veuillez réessayer plus tard."; // Message d'erreur système
        header('Location: /Click-Journey-adem/html/inscription.php'); // Redirige vers l'inscription
        exit();
    }
    
    $users = readCSV($csvPath); // Lit les données utilisateurs depuis le CSV
    foreach ($users as $user) { // Parcourt tous les utilisateurs existants



        if ($user['login'] === $data['login']) { // Vérifie si le login est déjà utilisé
    $_SESSION['error'] = "Ce login est déjà utilisé"; // Message d'erreur login existant




         header('Location: /Click-Journey-adem/html/inscription.php'); // Redirige vers l'inscription
            exit();
        }
    }

    $newUser = [ // Crée un nouvel utilisateur avec toutes ses données
        'login'           => $data['login'],
        'password'        => $data['password'],
        'role'            => 'user', // Rôle par défaut
        'nom'             => $data['nom'],
        'prenom'          => $data['prenom'],
        'date_naissance'  => $data['date_naissance'],
        'email'           => $data['email'],
        'telephone'       => $data['telephone'],
        'date_inscription' => date('Y-m-d') // Date d'inscription (aujourd'hui)
    ];
    
    $users[] = $newUser; // Ajoute le nouvel utilisateur à la liste
    $headers = ['login', 'password', 'role', 'nom', 'prenom', 'date_naissance', 'email', 'telephone', 'date_inscription']; // En-têtes du CSV
    
    if (writeCSV($csvPath, $users, $headers)) { // Tente d'écrire les données dans le fichier CSV
        $_SESSION['user_id'] = $newUser['login']; // Stocke l'ID utilisateur en session
        $_SESSION['user_role'] = $newUser['role']; // Stocke le rôle utilisateur en session
        $_SESSION['nom'] = $newUser['nom']; // Stocke le nom en session



        $_SESSION['prenom'] = $newUser['prenom']; // Stocke le prénom en session
        $_SESSION['email'] = $newUser['email']; // Stocke l'email en session




        $_SESSION['date_naissance'] = $newUser['date_naissance']; // Stocke la date de naissance en session
       
       
       
     $_SESSION['telephone'] = $newUser['telephone']; // Stocke le téléphone en session
        $_SESSION['success'] = "Inscription réussie, bienvenue " . $newUser['prenom'] . " " . $newUser['nom'] . " !"; // Message de bienvenue
        header('Location: /Click-Journey-adem/html/profil.php'); // Redirige vers la page de profil
        exit();
    } else { // Si l'écriture dans le fichier a échoué
      $_SESSION['error'] = "Erreur lors de l'inscription. Veuillez réessayer."; // Message d'erreur
        header('Location: /Click-Journey-adem/html/inscription.php'); // Redirige vers l'inscription
  exit();
    }
} else { // Si la page est accédée directement (sans POST)
   
   
 header('Location: /Click-Journey-adem/html/inscription.php'); // Redirige vers la page d'inscription





    exit();
}
?>

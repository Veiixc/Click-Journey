<?php 
require_once '../php/auth/check_auth.php';
redirectIfLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Inscription</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>
<body>
    <header>
        <div class="logo-conteneur">
            <a href="page-acceuil.php" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
        <div class="header-links">
            <a href="administrateur.php"><button>Administrateur</button></a>
            <a href="recherche.php"><button>Rechercher</button></a>
            <a href="présentation.php"><button>Notre agence</button></a>
            <a href="profil.php"><button>Profil</button></a>
            <a href="connexion.php"><button>Se connecter / S'inscrire</button></a>
        </div>
    </header>
    <div class="conteneur">
        <div id="formulaire-connexion" class="formulaire">
            <h2>Inscription</h2>
            <form id="register-form" method="post">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required>
                
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
                
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                
                <label for="date_naissance">Date de naissance</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
                
                <div class="form-bouton">
                    <button type="submit">S'inscrire</button>
                </div>
            </form>
            <p>Déjà un compte ? <a class="Connexion" href="connexion.php" id="montrer-connexion">Se connecter</a></p>
        </div>
    </div>
    <script src="../js/script.js"></script>
    <script>
    document.getElementById('register-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        fetch('/fin2/php/auth/register.php', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/fin2/html/connexion.php?success=1';
            } else {
                alert(data.message || 'Erreur lors de l\'inscription');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de l\'inscription');
        });
    });
    </script>
</body>
</html>
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
    <title>Connexion</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>

<body>
    <header>
        <div class="logo-conteneur">
            <a href="page-acceuil.html" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
        <div class="header-links">
            <!-- <button>Recherche de voyage</button> -->
            <a href="administrateur..php"><button>Administrateur</button></a>
            <a href="recherche..php"><button>Rechercher</button></a>
            <a href="présentation.php"><button>Notre agence</button></a>
            <a href="profil.php"><button>Profil</button></a>
            <a href="connexion.php"><button>Se connecter / S'inscrire</button></a>
        </div>
    </header>
    <div class="conteneur">
        <div id="formulaire-connexion" class="formulaire">
            <h2>Connexion</h2>
            <form id="login-form" method="post">
                <div id="message-erreur" style="color: red; display: none;"></div>
                <label for="login">Login ou e-mail</label>
                <input type="text" id="login" name="login" required>
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                <div class="form-bouton">
                    <button type="submit">Se connecter</button>
                </div>
            </form>
            <p>Pas de compte ? <a class="Connexion" href="inscription.html" id="montrer-inscription">S'inscrire</a></p>
        </div>
    </div>
    
<script>
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('/fin2/php/auth/login.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.role === 'admin') {
                window.location.href = '/fin2/html/administrateur.php';
            } else {
                window.location.href = '/fin2/html/profil.php';
            }
        } else {
            document.getElementById('message-erreur').style.display = 'block';
            document.getElementById('message-erreur').textContent = data.message;
        }
    });
});
</script>
</body>
</html>

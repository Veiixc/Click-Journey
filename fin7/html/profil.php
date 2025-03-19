<?php
require_once '../php/auth/check_auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Mon profil</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>
<body>
<div class="header-links">
    <a href="/fin2/html/administrateur.html"><button>Administrateur</button></a>
    <a href="/fin2/html/recherche.html"><button>Rechercher</button></a>
    <a href="/fin2/html/présentation.html"><button>Notre agence</button></a>
    <a href="/fin2/html/profil.html"><button>Profil</button></a>
    <a href="/fin2/php/auth/logout.php"><button>Déconnexion</button></a>
</div>
</body>
</html>

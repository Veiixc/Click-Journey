<?php
require_once '../../php/auth/check_auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/index.css">
    <link rel="stylesheet" type="text/css" href="../../css/circuit.css">
    <title>Circuit 2</title>
    <link rel="icon" type="img/png" href="../../img/logo-site.png">
    <script src="../../js/theme-switcher.js" defer></script>
</head>
<body>
    <header>
        <div class="logo-conteneur">
            <a href="../page-acceuil.php" class="logo"><img src="../../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
        <div class="header-links">
            <a href="../administrateur.php"><button>Administrateur</button></a>
            <a href="../recherche.php"><button>Rechercher</button></a>
            <a href="../présentation.php"><button>Notre agence</button></a>
            <a href="../profil.php"><button>Profil</button></a>
            <?php if(isLoggedIn()): ?>



                <a href="../../php/auth/logout.php"><button>Déconnexion</button></a>
            <?php else: ?>
                <a href="../connexion.php"><button>Se connecter / S'inscrire</button></a>
            <?php endif; ?>
        </div>
    </header>
    <div class="circuit-container">



        <h1>Circuit 2 : Trésors de l'Antiquité</h1>

        <div class="circuit-details">
            <div class="circuit-info">
                <div class="info-item">


                    <h3>Durée</h3>
         <p>20 jours</p>
                </div>
       <div class="info-item">


                    <h3>Prix</h3>
       <p>5989€</p>
                </div>
        <div class="info-item">
                    <h3>Transport</h3>
                    <p>Bateau</p>



                </div>
            </div>

            <div class="circuit-description">


   <p>Le voyage débute au Caire en Egypte, partez à la découverte d'une des civilisations les plus anciennes. L'hébergement se fera sur un bateau stationnant sur le Nil. Au bout de 5 jours, le ferry remontera le fleuve en direction d'Athènes. C'est dans cette cité, berceau de la civilisation grecque que vous passerez 5 nuits. Vous serez accueilli dans un hôtel 5 étoiles, juste au pied de l'acropole. Enfin les 5 dernières journées du voyage se tiendront à Istanbul, en Turquie. Vous aurez l'occasion de contempler les vestiges de l'empire Byzantin et l'empire Ottoman.</p>
            </div>

            <a href="../reservation.php?circuit=2" class="reserve-button">Réserver ce circuit</a>
        </div>
    </div>

</body>
</html>

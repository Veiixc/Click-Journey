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
    <title>Circuit 11</title>
    <link rel="icon" type="img/png" href="../../img/logo-site.png">
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
        <h1>Circuit 11 : Vietnam Impérial</h1>


        
        <div class="circuit-details">
            <div class="circuit-info">
                <div class="info-item">
                    <h3>Durée</h3>
                    <p>15 jours</p>
                </div>
                <div class="info-item">
                    <h3>Prix</h3>
                    <p>3699€</p>



                </div>
                <div class="info-item">
                    <h3>Transport</h3>
                    <p>Train/bateau</p>
                </div>

                
            </div>
            
            <div class="circuit-description">
                <p>Du delta du Mékong à la baie d'Halong, découvrez toute la richesse culturelle et naturelle du Vietnam. Visitez les temples d'Hanoi, naviguez entre les pains de sucre de la baie d'Halong, explorez l'ancienne cité impériale de Hué et terminez par la vibrante Ho Chi Minh-Ville.</p>
            </div>
            
            <a href="../reservation.php?circuit=11" class="reserve-button">Réserver ce circuit</a>
        </div>
    </div>
</body>
</html>
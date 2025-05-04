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
    <title>Circuit 10</title>
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



        <h1>Circuit 10 : Inde du Sud</h1>
        
        <div class="circuit-details">
            <div class="circuit-info">



                <div class="info-item">
                    <h3>Durée</h3>
                    <p>14 jours</p>
                </div>


                <div class="info-item">
                    <h3>Prix</h3>
                    
                    <p>3799€</p>
                </div>
                <div class="info-item">
                    <h3>Transport</h3>
                    <p>Train</p>
                </div>
            </div>
            
            <div class="circuit-description">
                <p>Découvrez la magie du Kerala et des temples dravidiens du Tamil Nadu. Naviguez sur les backwaters à bord d'un house-boat traditionnel, explorez les plantations d'épices des Ghats occidentaux, et émerveillez-vous devant les somptueux temples de Madurai et Tanjore. Un voyage entre nature luxuriante et spiritualité millénaire.</p>
            </div>
            
            <a href="../reservation.php?circuit=10" class="reserve-button">Réserver ce circuit</a>
        </div>
    </div>
</body>
</html>
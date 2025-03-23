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
    <title>Circuit 15</title>


    
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
        <h1>Circuit 15 : Le Transsibérien</h1>
        
        <div class="circuit-details">
            <div class="circuit-info">
                <div class="info-item">
              <h3>Durée</h3>
                    <p>18 jours</p>
              </div>





                <div class="info-item">
           <h3>Prix</h3>
                    <p>4899€</p>
       </div>
                <div class="info-item">
                    <h3>Transport</h3>
         <p>Train</p>
                </div>
          </div>




    
         <div class="circuit-description">
                <p>Embarquez pour l'aventure légendaire du Transsibérien, de Moscou à Vladivostok. Traversez 7 fuseaux horaires et 9289 kilomètres à bord du train mythique. Découvrez les rives du lac Baïkal, les steppes de Sibérie et les traditions locales. Des arrêts sont prévus dans les villes principales pour des visites culturelles.</p>
     </div>
            
    <a href="../reservation.php?circuit=15" class="reserve-button">Réserver ce circuit</a>
        </div>
    </div>
</body>
</html>
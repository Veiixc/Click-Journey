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
    <title>Circuit 1</title>
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
    <main>
        <div class="circuit-container">
            <h1>Circuit 1 : Découverte de l'Asie Impériale</h1>
    
            <div class="circuit-details">
                <div class="circuit-info">
                    <div class="info-item">
            <h3>Durée</h3>
                        <p>15 jours</p>


          </div>
                    <div class="info-item">
                        <h3>Prix</h3>
                        <p>4789€</p>



                    </div>
     <div class="info-item">
                                        <h3>Transport</h3>
                        <p>Bateau et/ou avion</p>
       </div>
                </div>
        
                <div class="circuit-description">
      <p>Le voyage débute à Kyoto dans l'ancienne capitale impériale du Japon, vous serez hébergé dans un ryokan traditionnel 5 étoiles pendant 4 nuits. Le périple continue ensuite à Pékin dans un hôtel 5 étoiles situé à côté de la fameuse cité interdite. Après 5 nuits en chine, rendez-vous en Inde à Agra la vile où se trouve le Taj Mahal et le Fort rouge.</p>
                </div>
                
         <a href="../reservation.php?circuit=1" class="reserve-button">Réserver ce circuit</a>
            </div>
</div>
    </main>
 
</body>
</html>
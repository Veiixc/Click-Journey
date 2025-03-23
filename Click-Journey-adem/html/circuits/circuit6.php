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
    <title>Circuit 6</title>
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
        <h1>Circuit 6 : La Grèce Antique</h1>
        
        <div class="circuit-details">


            <div class="circuit-info">
                <div class="info-item">


                    <h3>Durée</h3>
                    <p>10 jours</p>



                </div>
                <div class="info-item">
                    <h3>Prix</h3>



                    <p>2599€</p>
                </div>
                <div class="info-item">
                    <h3>Transport</h3>



                    
                    <p>Bateau</p>
                </div>
            </div>
            
            <div class="circuit-description">
                <p>Embarquez pour un voyage fascinant au cœur de la Grèce antique. À Athènes, explorez l'Acropole et le Parthénon, témoins majestueux de l'âge d'or grec. Direction ensuite Delphes, sanctuaire mythique de l'oracle, niché dans un cadre montagneux spectaculaire. Le voyage se poursuit vers Olympie, berceau des Jeux Olympiques antiques, avant de rejoindre les îles grecques en bateau pour découvrir les trésors de Délos et Santorin.</p>
            </div>
            
            <a href="../reservation.php?circuit=6" class="reserve-button">Réserver ce circuit</a>
        </div>
    </div>
</body>
</html>

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
    <title>Circuit 4</title>
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
        <h1>Circuit 4 : Royaume-Uni Historique</h1>
        
        <div class="circuit-details">
            <div class="circuit-info">
                <div class="info-item">
                    <h3>Durée</h3>
                    <p>8 jours</p>
                </div>
                <div class="info-item">
                    <h3>Prix</h3>
                    <p>1800€</p>
                </div>
                <div class="info-item">
                    <h3>Transport</h3>
                    <p>Bus et train</p>
                </div>
            </div>
            
            <div class="circuit-description">
                <p>Votre voyage commence à Bath, ville célèbre pour ses bains romains et son architecture géorgienne. Pendant 2 jours, vous séjournerez dans un hôtel 4 étoiles situé au cœur du centre historique. Vous aurez l'occasion de vous détendre dans les thermes et de visiter l'abbaye de Bath. Ensuite, cap vers Édimbourg, la capitale écossaise riche en histoire et en mystères. Pendant 3 jours, vous explorerez le château d'Édimbourg, le Royal Mile et le palais de Holyroodhouse. L'hébergement se fera dans un hôtel 5 étoiles avec une vue imprenable sur la vieille ville. Enfin, direction Cardiff, la capitale du Pays de Galles. Vous passerez 3 jours à découvrir son magnifique château médiéval, la baie de Cardiff et le musée national du pays de Galles.</p>
            </div>
            
            <a href="../../html/reservation.php?circuit=4" class="reserve-button">Réserver ce circuit</a>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>

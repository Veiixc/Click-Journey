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
    <title>Circuit 3</title>
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
        <h1>Circuit 3 : L'Italie Historique</h1>

        <div class="circuit-details">


            <div class="circuit-info">



                <div class="info-item">
                    <h3>Durée</h3>
                    <p>11 jours</p>





                </div>
                <div class="info-item">
                    <h3>Prix</h3>
                    <p>2289€</p>
                </div>
                <div class="info-item">




                    <h3>Transport</h3>
                    <p>Train</p>
                </div>
            </div>


            
            <div class="circuit-description">
                <p>Bienvenue à Gênes, ville qui était autrefois l'une des plus grandes puissances maritimes. Son magnifique port et ses palais saurons vous en mettre plein la vue. Là-bas, vous séjournerez comme tout au long du voyage, dans un de nos hôtels partenaires pendant 3 jours. Poursuivez votre découverte de l'Italie, à Rome, ancienne capitale du puissant Empire Romain. Enfin finissez en beauté votre séjour dans la ville de Naples. C'est dans la colline la plus haute de la ville que vous séjournerez. Vous aurez un accès rapide au fameux Castel Nuovo ainsi, qu'à plusieurs vestiges datant de l'époque gréco-romaine où la Renaissance.</p>
            </div>

            <a href="../../html/reservation.php?circuit=3" class="reserve-button">Réserver ce circuit</a>
        </div>
    </div>
</body>
</html>

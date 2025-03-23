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
    <title>Circuit 5</title>
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


        <h1>Circuit 5 : L'héritage Maya</h1>



        
        <div class="circuit-details">
            <div class="circuit-info">



                <div class="info-item">
                    <h3>Durée</h3>
                    <p>13 jours</p>
                </div>
                <div class="info-item">



                    <h3>Prix</h3>
                    <p>3999€</p>
                </div>
                <div class="info-item">
                    <h3>Transport</h3>



                    <p>Bus et avion</p>
                </div>
            </div>
            
            <div class="circuit-description">


            
                <p>Plongez dans l'histoire fascinante de la civilisation maya avec notre circuit exclusif au Mexique. Le voyage commence à Chichen Itza, où vous serez hébergé dans un hôtel-boutique colonial 5 étoiles avec vue sur la pyramide de Kukulcán. Après 3 nuits, direction Uxmal pour explorer ce site spectaculaire et moins touristique, avec hébergement dans une hacienda historique restaurée. Le voyage se poursuit vers Palenque, niché dans la jungle, où vous passerez 3 nuits dans un éco-lodge de luxe. La dernière étape vous mène à Tulum, où vous profiterez de 4 nuits dans un resort en bord de mer, combinant sites archéologiques et détente sur les plages de la Riviera Maya.</p>
            </div>
            
            <a href="../reservation.php?circuit=5" class="reserve-button">Réserver ce circuit</a>
        </div>
    </div>
</body>
</html>

<?php
require_once '../php/auth/check_auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Notre Agence</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>

<body>
    <header>
        <div class="logo-conteneur">
            <a href="page-acceuil.php" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
        <div class="header-links">
            <a href="administrateur.php"><button>Administrateur</button></a>
            <a href="recherche.php"><button>Rechercher</button></a>
            <a href="présentation.php"><button>Notre agence</button></a>
            <a href="profil.php"><button>Profil</button></a>
            <?php if(isLoggedIn()): ?>
                <a href="../php/auth/logout.php"><button>Déconnexion</button></a>
            <?php else: ?>
                <a href="connexion.php"><button>Se connecter / S'inscrire</button></a>
            <?php endif; ?>
        </div>
    </header>
    <div class="conteneur">
        <h1>Voyages Recommandés</h1>
        <div id="voyages-recommandes" class="circuits-conteneur">
            <!-- Les voyages seront chargés dynamiquement ici -->
        </div>

        <h1>Découvrez nos circuits</h1>
        <div class="circuits-conteneur">
            <a href="circuits/circuit1.php" class="circuit">
                <h2>Circuit 1</h2>
                <p>Durée : 15 jours</p>
                <p>Prix : 4789€</p>
                <p>Moyens de locomotion : bateau et/ou avion</p>
                <p>Le voyage débute à Kyoto...</p>
            </a>
            <a href="circuits/circuit2.php" class="circuit">
                <h2>Circuit 2</h2>
                <p>Durée : 20 jours</p>
                <p>Prix : 5989€</p>
                <p>Moyens de locomotion : bateau</p>
                <p>Le voyage débute au Caire...</p>
            </a>
            <a href="circuits/circuit3.php" class="circuit">
                <h2>Circuit 3</h2>
                <p>Durée : 11 jours</p>
                <p>Prix : 2289€</p>
                <p>Moyens de locomotion : train</p>
                <p>Bienvenue à Gênes...</p>
            </a>
            <a href="circuits/circuit4.php" class="circuit">
                <h2>Circuit 4</h2>
                <p>Durée : 8 jours</p>
                <p>Prix : 1800€</p>
                <p>Moyens de locomotion : bus et train</p>
                <p>Votre voyage commence à Bath...</p>
            </a>
            <a href="circuits/circuit5.php" class="circuit">
                <h2>Circuit 5</h2>
                <p>Durée : 13 jours</p>
                <p>Prix : 3999€</p>
                <p>Moyens de locomotion : bus et avion</p>
                <p>Découvrez les sites mayas...</p>
            </a>
            <a href="circuits/circuit6.php" class="circuit">
                <h2>Circuit 6</h2>
                <p>Durée : 10 jours</p>
                <p>Prix : 2999€</p>
                <p>Moyens de locomotion : voiture</p>
                <p>Explorez les Alpes...</p>
            </a>
            <a href="circuits/circuit7.php" class="circuit">
                <h2>Circuit 7</h2>
                <p>Durée : 16 jours</p>
                <p>Prix : 4299€</p>
                <p>Moyens de locomotion : train/bus</p>
                <p>Découvrez les monastères du toit du monde...</p>
            </a>
            <a href="circuits/circuit8.php" class="circuit">
                <h2>Circuit 8</h2>
                <p>Durée : 12 jours</p>
                <p>Prix : 3499€</p>
                <p>Moyens de locomotion : bus/bateau</p>
                <p>Explorez les temples d'Angkor...</p>
            </a>
            <a href="circuits/circuit9.php" class="circuit">
                <h2>Circuit 9</h2>
                <p>Durée : 14 jours</p>
                <p>Prix : 4599€</p>
                <p>Moyens de locomotion : avion</p>
                <p>Découvrez les merveilles de l'Australie...</p>
            </a>
            <a href="circuits/circuit10.php" class="circuit">
                <h2>Circuit 10</h2>
                <p>Durée : 7 jours</p>
                <p>Prix : 1999€</p>
                <p>Moyens de locomotion : train</p>
                <p>Visitez les châteaux de la Loire...</p>
            </a>
            <a href="circuits/circuit11.php" class="circuit">
                <h2>Circuit 11</h2>
                <p>Durée : 9 jours</p>
                <p>Prix : 2599€</p>
                <p>Moyens de locomotion : bus</p>
                <p>Partez à la découverte de l'Andalousie...</p>
            </a>
            <a href="circuits/circuit12.php" class="circuit">
                <h2>Circuit 12</h2>
                <p>Durée : 16 jours</p>
                <p>Prix : 4999€</p>
                <p>Moyens de locomotion : bateau</p>
                <p>Explorez les fjords de Norvège...</p>
            </a>
            <a href="circuits/circuit13.php" class="circuit">
                <h2>Circuit 13</h2>
                <p>Durée : 18 jours</p>
                <p>Prix : 5499€</p>
                <p>Moyens de locomotion : avion</p>
                <p>Découvrez les merveilles de l'Amérique du Sud...</p>
            </a>
            <a href="circuits/circuit14.php" class="circuit">
                <h2>Circuit 14</h2>
                <p>Durée : 21 jours</p>
                <p>Prix : 5999€</p>
                <p>Moyens de locomotion : bateau et avion</p>
                <p>Partez à l'aventure en Antarctique...</p>
            </a>
            <a href="circuits/circuit15.php" class="circuit">
                <h2>Circuit 15</h2>
                <p>Durée : 18 jours</p>
                <p>Prix : 4899€</p>
                <p>Moyens de locomotion : train</p>
                <p>Le Transsibérien de Moscou à Vladivostok...</p>
            </a>
            <a href="circuits/circuit16.php" class="circuit">
                <h2>Circuit 16</h2>
                <p>Durée : 14 jours</p>
                <p>Prix : 3999€</p>
                <p>Moyens de locomotion : 4x4/train</p>
                <p>Les steppes mongoles et la vie nomade...</p>
            </a>
            <a href="circuits/circuit17.php" class="circuit">
                <h2>Circuit 17</h2>
                <p>Durée : 15 jours</p>
                <p>Prix : 3799€</p>
                <p>Moyens de locomotion : bus/avion</p>
                <p>Trek dans l'Himalaya et découverte des temples...</p>
            </a>
        </div>
        <div class="conteneur">
            <h1>L'équipe</h1>
            <section class="membres">



                <div class="cartes">
                    <div class="nom-membre">AGBAVOR Emmanuel</div>
                    <div class="role-membre">Membre de l'équipe</div>
                </div>
                <div class="cartes">
                    <div class="nom-membre">BRINGUIER Valérian</div>
                    <div class="role-membre">Membre de l'équipe</div>
                </div>
                <div class="cartes">
                    <div class="nom-membre">HOUIDI ADEM</div>
                    <div class="role-membre">Membre de l'équipe</div>


                </div>
            </section>
        </div>
        <div class="conteneur">
            <h1>Nos retours</h1>
        </div>
        <footer>
            <a href="page.php"><img src="../img/twitter.jpg"></a>
            <a href="page.php"><img src="../img/insta.jpg"></a>
            <a href="page.php"><img src="../img/linkedin.jpg"></a>
        </footer>
    </div>
    <script src="../js/voyages.js"></script>
</body>

</html>
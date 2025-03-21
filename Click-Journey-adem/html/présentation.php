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
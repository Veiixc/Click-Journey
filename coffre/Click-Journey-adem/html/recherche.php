<?php
require_once '../php/auth/check_auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Recherche</title>
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
    <a href="../php/auth/logout.php"><button>Déconnexion</button></a>
</div>


    </header>
    <div class="conteneur">
        <section class="conteneur-recherche">
            <h1>Trouvez Votre Prochaine Aventure</h1>
            <form class="filtres-recherche">
                <div class="grille-filtres">
                    <div class="groupe-filtre">
                        <label for="transport-selection">Moyen de Transport</label>
                        <select id="transport-selection" name="transport">
                            <option value="">Tous les Transports</option>
                            <option value="avion">Avion</option>
                            <option value="bateau">Bateau</option>
                            <option value="train">Train</option>
                            <option value="voiture">Voiture</option>
                        </select>
                    </div>
                    <div class="groupe-filtre">
                        <label for="selection-budget">Budget</label>
                        <select id="selection-budget" name="prix">
                            <option value="">Toutes les Tranches</option>
                            <option value="0-500">0 - 500€</option>
                            <option value="500-1000">500 - 1000€</option>
                            <option value="1000-2000">1000 - 2000€</option>
                            <option value="2000+">2000€ et +</option>
                        </select>
                    </div>
                    <div class="groupe-filtre">
                        <label for="selection-duree">Durée du Séjour</label>
                        <select id="selection-duree" name="duree">
                            <option value="">Toutes Durées</option>
                            <option value="weekend">Week-end</option>
                            <option value="semaine">1 semaine</option>
                            <option value="quinzaine">2 semaines</option>
                            <option value="mois">1 mois</option>
                        </select>
                    </div>
                    <div class="groupe-filtre">
                        <label for="champ-destination">Destination</label>
                        <input type="text" id="champ-destination" name="destination" placeholder="...">
                    </div>
                </div>
                <div class="filtres-supplementaires">
                    <div class="groupe-filtre">
                        <label for="date-depart">Date de Départ</label>
                        <input type="date" id="date-depart" name="date-depart">
                    </div>
                    <div class="groupe-filtre">
                        <label for="nombre-personnes">Nombre de Personnes</label>
                        <input type="number" id="nombre-personnes" name="personnes" min="1" max="10" value="1">
                    </div>
                </div>
                <button type="submit" class="bouton-recherche">
                    Rechercher des Voyages
                </button>
            </form>
        </section>
    </div>
</body>
</html>

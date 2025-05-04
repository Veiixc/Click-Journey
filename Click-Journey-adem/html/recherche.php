<?php
require_once '../php/auth/check_auth.php';
require_once '../php/includes/functions.php';


$voyages_par_page = 6;
$page_courante = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$voyages = [];
if (isset($_GET['destination']) && !empty($_GET['destination'])) {
    $keyword = strtolower($_GET['destination']);
    $allVoyages = readCSV('../php/data/voyages.csv');
    
    $voyages = array_filter($allVoyages, function($voyage) use ($keyword) {
        return strpos(strtolower($voyage['titre']), $keyword) !== false ||
               strpos(strtolower($voyage['description']), $keyword) !== false;
    });

    $nombre_total_voyages = count($voyages);
    $nombre_total_pages = ceil($nombre_total_voyages / $voyages_par_page);
    
    $voyages = array_slice($voyages, ($page_courante - 1) * $voyages_par_page, $voyages_par_page);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/voyages.css">
    <title>Recherche</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
    <script src="../js/voyages.js" defer></script>
    <script src="../js/theme-switcher.js" defer></script>
    <script src="../js/cart-persistence.js" defer></script>
    <style>
        /* Styles supplémentaires pour les options de tri */
        .sort-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 1;
            transition: opacity 0.5s;
        }
        
        .sort-notification.fade-out {
            opacity: 0;
        }
        
        .sorting-options {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sorting-options select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
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
            <a href="cart.php"><button>Panier</button></a>
            <a href="profil.php"><button>Profil</button></a>
            <?php if(isLoggedIn()): ?>
                <a href="../php/auth/logout.php"><button>Déconnexion</button></a>
            <?php else: ?>
                <a href="connexion.php"><button>Se connecter / S'inscrire</button></a>
            <?php endif; ?>
        </div>
    </header>
    <div class="conteneur">
        <section class="conteneur-recherche">
            <h1>Trouvez Votre Prochaine Aventure</h1>
            <form class="filtres-recherche" method="GET">
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
                        <input type="text" id="champ-destination" name="destination" placeholder="..." value="<?php echo isset($_GET['destination']) ? htmlspecialchars($_GET['destination']) : ''; ?>">
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

            <!-- Le conteneur des circuits ici, pas besoin d'ajouter les options de tri, 
                 elles seront ajoutées dynamiquement par JavaScript -->
            <div class="circuits-conteneur">
                <?php if (!empty($_GET['destination'])): ?>
                    <?php if (empty($voyages)): ?>
                        <p>Aucun voyage trouvé</p>
                    <?php else: ?>
                        <?php foreach ($voyages as $voyage): ?>
                            <a href="circuits/circuit<?php echo $voyage['id']; ?>.php" class="circuit" 
                               data-prix="<?php echo htmlspecialchars($voyage['prix']); ?>"
                               data-duree="<?php echo htmlspecialchars($voyage['duree']); ?>"
                               data-note="<?php echo htmlspecialchars($voyage['note']); ?>"
                               data-date="<?php echo isset($voyage['date_ajout']) ? htmlspecialchars($voyage['date_ajout']) : date('Y-m-d'); ?>">
                                <div class="circuit-badge"><?php echo htmlspecialchars($voyage['note']); ?> ⭐</div>
                                <h2><?php echo htmlspecialchars($voyage['titre']); ?></h2>
                                <p><strong>Durée :</strong> <?php echo htmlspecialchars($voyage['duree']); ?> jours</p>
                                <p><strong>Prix :</strong> <?php echo htmlspecialchars($voyage['prix']); ?>€</p>
                                <p><strong>Transport :</strong> <?php echo htmlspecialchars($voyage['transport']); ?></p>
                                <div class="circuit-description">
                                    <?php 
                                    $description = $voyage['description'];
                                    echo htmlspecialchars(strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description); 
                                    ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                        
                        <?php if (isset($nombre_total_pages) && $nombre_total_pages > 1): ?>
                            <div class="pagination">
                                <?php if ($page_courante > 1): ?>
                                    <a href="?destination=<?php echo urlencode($_GET['destination']); ?>&page=<?php echo ($page_courante - 1); ?>">&laquo; Précédent</a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $nombre_total_pages; $i++): ?>
                                    <a href="?destination=<?php echo urlencode($_GET['destination']); ?>&page=<?php echo $i; ?>" 
                                       class="<?php echo ($i === $page_courante) ? 'active' : ''; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($page_courante < $nombre_total_pages): ?>
                                    <a href="?destination=<?php echo urlencode($_GET['destination']); ?>&page=<?php echo ($page_courante + 1); ?>">Suivant &raquo;</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>
</body>
</html>

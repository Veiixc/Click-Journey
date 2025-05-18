<?php


// Inclusion des fichiers nécessaires et vérification de l'authentification
require_once '../php/auth/check_auth.php';
require_once '../php/cart/cart_functions.php';
requireLogin();

// Récupération de l'ID du circuit depuis l'URL
$circuit_id = isset($_GET['circuit']) ? $_GET['circuit'] : null;
if (!$circuit_id) {
    // Redirection si aucun circuit n'est spécifié
    header('Location: presentation.html');
    exit();
}

// Si un cart_item_id est passé en paramètre, le sauvegarder dans une variable de session
// pour aider la récupération des options sauvegardées
if (isset($_GET['cart_item_id'])) {
    $_SESSION['current_cart_item_id'] = $_GET['cart_item_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/journey.css">
    <title>Réservation</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
    <style>
        /* Styles pour les notifications affichées lors des sauvegardes */
        .notification {
            position: fixed;
            top: 80px;
            right: 20px;
            padding: 15px 20px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 1000;
            opacity: 1;
            transition: opacity 0.5s;
        }
        
        .fade-out {
            opacity: 0;
        }
        
        /* Indicateur de sauvegarde automatique en bas à droite */
        .auto-save-indicator {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 8px 12px;
            background-color: rgba(0,0,0,0.7);
            color: white;
            border-radius: 4px;
            font-size: 14px;
            z-index: 1000;
            display: none;
        }
        
        /* Style pour le message d'information en haut du formulaire */
        .info-message {
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #e7f3fe;
            border-left: 4px solid #2196F3;
            color: #0c5460;
        }
        
        .info-message p {
            margin: 0;
        }
        
        .info-message i {
            margin-right: 8px;
            color: #2196F3;
        }
        
        /* Indicateur de chargement pour les options dynamiques */
        .loading-indicator {
            text-align: center;
            padding: 20px;
            font-size: 16px;
            color: #666;
        }
        
        .loading-indicator i {
            display: inline-block;
            margin-right: 8px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- En-tête du site avec navigation -->
    <header>
        <div class="logo-conteneur">
            <a href="accueil.php" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
        <div class="header-links">
            <a href="administrateur.php"><button>Administrateur</button></a>
            <a href="recherche.php"><button>Rechercher</button></a>
            <a href="présentation.php"><button>Notre agence</button></a>
            <!-- Affichage du nombre d'éléments dans le panier -->
            <a href="cart.php" class="cart-badge"><button>Panier</button>
                <?php if(getCartItemCount() > 0): ?>
                    <span class="cart-count"><?php echo getCartItemCount(); ?></span>
                <?php endif; ?>
            </a>
            <a href="profil.php"><button>Profil</button></a>
            <a href="../php/auth/logout.php"><button>Se déconnecter</button></a>
        </div>
    </header>
    
    <div class="conteneur">
        <div class="formulaire reservation-form">
            <h2>Personnalisation du Circuit <?php echo htmlspecialchars($circuit_id); ?></h2>
            
            <!-- Message d'information sur la sauvegarde automatique -->
            <div class="info-message">
                <p><i class="fas fa-info-circle"></i> Toutes vos modifications sont automatiquement sauvegardées dans votre panier.</p>
            </div>
            
            <!-- Formulaire de personnalisation du circuit -->
            <form action="../php/reservations/save_choices.php" method="POST">
                <!-- Champs cachés pour identifier le circuit et l'élément du panier -->
                <input type="hidden" name="circuit_id" value="<?php echo htmlspecialchars($circuit_id); ?>">
                <?php if (isset($_SESSION['current_cart_item_id'])): ?>
                <input type="hidden" name="cart_item_id" value="<?php echo htmlspecialchars($_SESSION['current_cart_item_id']); ?>">
                <?php endif; ?>

                <!-- Sélection des dates de début et de fin -->
                <div class="form-group date-selection">
                    <div class="option-group">
                        <label for="date_debut">Date de début</label>
                        <input type="date" id="date_debut" name="date_debut" required 
                               min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="option-group">
                        <label for="date_fin">Date de fin</label>
                        <input type="date" id="date_fin" name="date_fin" required>
                    </div>
                </div>

                <!-- Sélection du nombre de personnes -->
                <div class="form-group">
                    <label for="nb_personnes">Nombre de personnes</label>
                    <select id="nb_personnes" name="nb_personnes" required>
                        <?php for($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?> personne<?php echo $i > 1 ? 's' : ''; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Zone de chargement dynamique des étapes du circuit -->
                <div class="journey-stages">
                    <!-- L'indicateur de chargement qui sera remplacé par les étapes dynamiques -->
                    <div class="loading-indicator">
                        <i class="fas fa-circle-notch"></i> Chargement des options...
                    </div>
                </div>
                
                <!-- Bouton pour finaliser et voir le récapitulatif -->
                <button type="submit" class="summary-button">Voir le récapitulatif</button>
            </form>
        </div>
    </div>
    
    <!-- Indicateur de sauvegarde automatique -->
    <div class="auto-save-indicator" style="display: none;">Modifications sauvegardées</div>
    
    <!-- Passer l'ID de l'élément du panier au JavaScript si disponible -->
    <?php if (isset($_SESSION['current_cart_item_id'])): ?>
    <script>
        // Variable globale pour stocker l'ID du panier
        var currentCartItemId = "<?php echo htmlspecialchars($_SESSION['current_cart_item_id']); ?>";
        console.log("ID de l'élément du panier à charger:", currentCartItemId);
    </script>
    <?php endif; ?>
    
    <!-- Chargement des polices et icônes Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Scripts JavaScript pour la gestion dynamique du formulaire -->
    <script src="../js/script.js"></script>
    <script src="../js/dynamic-options.js"></script> <!-- Charge dynamiquement les options du circuit -->
    <script src="../js/dynamic-pricing.js"></script> <!-- Calcule le prix en fonction des options -->
    <script src="../js/auto-add-to-cart.js"></script> <!-- Sauvegarde automatique dans le panier -->
</body>
</html>

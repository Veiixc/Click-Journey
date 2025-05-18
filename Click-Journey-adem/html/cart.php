<?php
require_once '../php/auth/check_auth.php';
require_once '../php/cart/cart_functions.php';
requireLogin();

// Traitement des actions POST (supprimer, payer, modifier un élément du panier)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   if (isset($_POST['action'])) {
      switch ($_POST['action']) {
         // Action pour supprimer un élément du panier
         case 'remove':
                if (isset($_POST['cart_item_id'])) {
                    removeFromCart($_POST['cart_item_id']);
                $_SESSION['success'] = "Voyage retiré du panier";
                }
                break;
                
            // Action pour procéder au paiement d'un élément du panier
            case 'proceed_to_payment':
                if (isset($_POST['cart_item_id'])) {
                   // Marquer l'élément comme prêt pour le paiement
                   setCartItemReadyToPay($_POST['cart_item_id']);
                    
                  // Récupération des données du voyage pour la page de paiement
                  $cart_items = getCartItems();
                   $cart_item = $cart_items[$_POST['cart_item_id']];
                    
                   // Stockage des informations du voyage dans la session pour le processus de paiement
                   $_SESSION['circuit_id'] = $cart_item['journey_data']['circuit_id'];
                  $_SESSION['date_debut'] = $cart_item['journey_data']['date_debut'];
                 $_SESSION['date_fin'] = $cart_item['journey_data']['date_fin'];
                    $_SESSION['nb_personnes'] = $cart_item['journey_data']['nb_personnes'];
                $_SESSION['journey_stages'] = $cart_item['journey_data']['journey_stages'];
                    $_SESSION['prix_total'] = $cart_item['journey_data']['prix_total'] ?? 0;
                    
                    // Redirection vers la page de paiement
                    header('Location: payment.php');
                    exit();
                }
                break;
                
            // Action pour continuer à personnaliser un voyage
            case 'continue_editing':
             if (isset($_POST['cart_item_id'])) {
                   $cart_items = getCartItems();
                 $cart_item = $cart_items[$_POST['cart_item_id']];
                    
                   // Redirection vers la page de réservation avec l'ID du circuit et l'ID de l'élément du panier
                   header('Location: reservation.php?circuit=' . $cart_item['circuit_id'] . '&cart_item_id=' . $_POST['cart_item_id']);
                    exit();
                }
           break;
        }
    }
}

// Récupération des éléments du panier pour affichage
$cart_items = getCartItems();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/journey.css">
    <title>Mon Panier - Time Traveler</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
    <!-- Scripts JS pour la gestion du thème, des notifications et de la persistance du panier -->
    <script src="../js/theme-switcher.js" defer></script>
    <script src="../js/notifications.js" defer></script>
    <script src="../js/cart-persistence.js" defer></script>
    <style>
        /* Styles CSS spécifiques à la page panier */
        .cart-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .cart-item {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .cart-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        
        .cart-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 15px;
        }
        
        .cart-actions button {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .cart-actions .remove-btn {
            background-color: #f44336;
            color: white;
        }
        
        .cart-actions .edit-btn {
            background-color: #2196F3;
            color: white;
        }
        
        .cart-actions .pay-btn {
            background-color: #4CAF50;
            color: white;
        }
        
        .empty-cart {
            text-align: center;
            padding: 40px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        
        .cart-summary {
            margin-top: 10px;
        }
        
        .cart-summary p {
            margin: 5px 0;
        }
        
        /* Styles pour les badges de statut des éléments du panier */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
            color: white;
        }
        
        .status-badge.needs-customization {
            background-color: #ff9800; /* Orange */
        }
        
        .status-badge.in-progress {
            background-color: #2196F3; /* Bleu */
        }
        
        .status-badge.ready {
            background-color: #4CAF50; /* Vert */
        }
        
        /* Styles pour le résumé des options dans le panier */
        .journey-options-summary {
            margin-top: 10px;
        }
        
        .journey-options-summary details {
            margin-top: 5px;
        }
        
        .journey-options-summary summary {
            cursor: pointer;
            color: #2196F3;
            font-weight: bold;
        }
        
        .options-detail {
            margin-top: 10px;
            padding: 10px;
            background-color: #f5f5f5;
            border-radius: 4px;
        }
        
        .stage-summary {
            margin-bottom: 15px;
        }
        
        .stage-summary h4 {
            margin: 5px 0;
            font-size: 16px;
            color: #333;
        }
        
        .stage-summary ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .stage-summary li {
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <!-- En-tête du site avec le logo et les liens de navigation -->
    <header>
        <div class="logo-conteneur">
            <a href="page-acceuil.php" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
        <div class="header-links">
            <a href="administrateur.php"><button>Administrateur</button></a>
            <a href="recherche.php"><button>Rechercher</button></a>
            <a href="présentation.php"><button>Notre agence</button></a>
            <!-- Affichage du nombre d'éléments dans le panier à côté du bouton Panier -->
            <a href="cart.php" class="cart-badge"><button>Panier</button>
                <?php if(getCartItemCount() > 0): ?>
                    <span class="cart-count"><?php echo getCartItemCount(); ?></span>
                <?php endif; ?>
            </a>
            <a href="profil.php"><button>Profil</button></a>
            <a href="../php/auth/logout.php"><button>Déconnexion</button></a>
        </div>
    </header>
    
    <div class="conteneur">
        <div class="cart-container">
            <h2>Mon Panier</h2>
            
            <!-- Affichage des messages de succès -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success-message">
                    <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>
            
            <!-- Affichage conditionnel selon que le panier est vide ou non -->
            <?php if (empty($cart_items)): ?>
                <!-- Message affiché si le panier est vide -->
                <div class="empty-cart">
                    <p>Votre panier est vide.</p>
                    <a href="présentation.php" class="summary-button">Découvrir nos voyages</a>
                </div>
            <?php else: ?>
                <!-- Boucle d'affichage des éléments du panier -->
                <?php foreach ($cart_items as $cart_item_id => $item): ?>
                    <div class="cart-item">
                        <div class="cart-item-header">
                            <h3>Circuit <?php echo htmlspecialchars($item['circuit_id']); ?></h3>
                            <span>Ajouté le: <?php echo date('d/m/Y', strtotime($item['date_added'])); ?></span>
                        </div>
                        
                        <!-- Résumé des détails du voyage -->
                        <div class="cart-summary">
                            <?php if (isset($item['journey_data']['date_debut'])): ?>
                                <p><strong>Date de début:</strong> <?php echo date('d/m/Y', strtotime($item['journey_data']['date_debut'])); ?></p>
                            <?php endif; ?>
                            
                            <?php if (isset($item['journey_data']['date_fin'])): ?>
                                <p><strong>Date de fin:</strong> <?php echo date('d/m/Y', strtotime($item['journey_data']['date_fin'])); ?></p>
                            <?php endif; ?>
                            
                            <?php if (isset($item['journey_data']['nb_personnes'])): ?>
                                <p><strong>Nombre de personnes:</strong> <?php echo $item['journey_data']['nb_personnes']; ?></p>
                            <?php endif; ?>
                            
                            <?php if (isset($item['journey_data']['prix_total'])): ?>
                                <p><strong>Prix total:</strong> <?php echo $item['journey_data']['prix_total']; ?> €</p>
                            <?php endif; ?>
                            
                            <!-- Affichage des étapes du voyage si elles existent -->
                            <?php if (isset($item['journey_data']['journey_stages']) && !empty($item['journey_data']['journey_stages'])): ?>
                                <p><strong>Étapes:</strong> <?php echo count($item['journey_data']['journey_stages']); ?> étape(s)</p>
                                
                                <!-- Section dépliable montrant les détails des options choisies -->
                                <div class="journey-options-summary">
                                    <details>
                                        <summary>Voir les options sélectionnées</summary>
                                        <div class="options-detail">
                                            <?php foreach ($item['journey_data']['journey_stages'] as $index => $stage): ?>
                                                <div class="stage-summary">
                                                    <h4><?php echo htmlspecialchars($stage['title']); ?></h4>
                                                    <ul>
                                                        <?php if (!empty($stage['lodging'])): ?>
                                                            <li><strong>Hébergement:</strong> <?php echo htmlspecialchars($stage['lodging']); ?></li>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($stage['meals'])): ?>
                                                            <li><strong>Repas:</strong> <?php echo htmlspecialchars($stage['meals']); ?></li>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($stage['activities'])): ?>
                                                            <li>
                                                                <strong>Activités:</strong> 
                                                                <?php 
                                                                // Gestion des activités sous forme de tableau ou de chaîne
                                                                if (is_array($stage['activities'])) {
                                                                    echo htmlspecialchars(implode(', ', $stage['activities']));
                                                                } else {
                                                                    echo htmlspecialchars($stage['activities']);
                                                                }
                                                                ?>
                                                            </li>
                                                        <?php endif; ?>
                                                        
                                                        <?php if (!empty($stage['transport'])): ?>
                                                            <li><strong>Transport:</strong> <?php echo htmlspecialchars($stage['transport']); ?></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </details>
                                </div>
                            <?php else: ?>
                                <!-- Affichage du statut si aucune étape n'est définie -->
                                <p><strong>Statut:</strong> 
                                    <?php 
                                    // Affichage du badge de statut avec couleur différente selon l'état
                                    if ($item['status'] == 'to_customize') {
                                        echo '<span class="status-badge needs-customization">À personnaliser</span>';
                                    } elseif ($item['status'] == 'in_progress') {
                                        echo '<span class="status-badge in-progress">Personnalisation en cours</span>';
                                    } else {
                                        echo '<span class="status-badge ready">Prêt pour paiement</span>';
                                    }
                                    ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Boutons d'action pour chaque élément du panier -->
                        <div class="cart-actions">
                            <!-- Formulaire pour supprimer l'élément du panier -->
                            <form method="POST">
                                <input type="hidden" name="cart_item_id" value="<?php echo $cart_item_id; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="remove-btn">Supprimer</button>
                            </form>
                            
                            <!-- Formulaire pour modifier/personnaliser l'élément du panier -->
                            <form method="POST">
                                <input type="hidden" name="cart_item_id" value="<?php echo $cart_item_id; ?>">
                                <input type="hidden" name="action" value="continue_editing">
                                <button type="submit" class="edit-btn">
                                    <?php echo ($item['status'] == 'to_customize') ? 'Personnaliser' : 'Modifier'; ?>
                                </button>
                            </form>
                            
                            <!-- Formulaire pour procéder au paiement (visible uniquement si le voyage est personnalisé ou prêt) -->
                            <?php if ($item['status'] != 'to_customize' || !empty($item['journey_data']['journey_stages'])): ?>
                            <form method="POST">
                                <input type="hidden" name="cart_item_id" value="<?php echo $cart_item_id; ?>">
                                <input type="hidden" name="action" value="proceed_to_payment">
                                <button type="submit" class="pay-btn">Payer</button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Pied de page du site -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>À propos de nous</h3>
                <p>Time Traveler est une agence de voyage spécialisée dans les circuits personnalisés à travers le monde.</p>
            </div>
            <div class="footer-section">
                <h3>Contactez-nous</h3>
                <p>Email: contact@timetraveler.com</p>
                <p>Téléphone: +33 1 23 45 67 89</p>
            </div>
            <div class="footer-section">
                <h3>Suivez-nous</h3>
                <div class="social-links">
                    <a href="https://twitter.com"><img src="../img/twitter.jpg" alt="Twitter"></a>
                    <a href="https://instagram.com"><img src="../img/insta.jpg" alt="Instagram"></a>
                    <a href="https://linkedin.com"><img src="../img/linkedin.jpg" alt="LinkedIn"></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 Time Traveler. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
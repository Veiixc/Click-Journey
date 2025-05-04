<?php

require_once     '../php/auth/check_auth.php';
require_once        '../php/cart/cart_functions.php';
requireLogin(    );

if (    $_SERVER['REQUEST_METHOD']    === 'POST'    ) {
   if (   isset($_POST['action'])     ) {
      switch (    $_POST['action']   ) {
         case     'remove':
                if (   isset($_POST['cart_item_id'])   ) {
                    removeFromCart(  $_POST['cart_item_id']  );
                $_SESSION['success']   = "Voyage retiré du panier";
                }
                break;
                
            case    'proceed_to_payment':
                if (   isset(   $_POST['cart_item_id']  )   ) {
                   setCartItemReadyToPay(   $_POST['cart_item_id']   );
                    
                  $cart_items = getCartItems(    );
                   $cart_item =   $cart_items[$_POST['cart_item_id']];
                    
                   $_SESSION['circuit_id']      = $cart_item['journey_data']['circuit_id'];
                  $_SESSION['date_debut']    = $cart_item['journey_data']['date_debut'];
                 $_SESSION['date_fin']     = $cart_item['journey_data']['date_fin'];
                    $_SESSION['nb_personnes']    = $cart_item['journey_data']['nb_personnes'];
                $_SESSION['journey_stages']   = $cart_item['journey_data']['journey_stages'];
                    $_SESSION['prix_total']  = $cart_item['journey_data']['prix_total'] ?? 0;
                    
                    header(  'Location: payment.php'  );
                    exit(  );
                }
                break;
                
            case   'continue_editing':
             if (      isset($_POST['cart_item_id'])    ) {
                   $cart_items  = getCartItems(   );
                 $cart_item   = $cart_items[$_POST['cart_item_id']];
                    
                   header(   'Location: reservation.php?circuit=' . $cart_item['circuit_id']   );
                    exit(   );
                }
           break;
        }
    }
}

$cart_items   = getCartItems(  );
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
    <script src="../js/theme-switcher.js" defer></script>
    <script src="../js/notifications.js" defer></script>
    <script src="../js/cart-persistence.js" defer></script>
    <style>
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
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success-message">
                    <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($cart_items)): ?>
                <div class="empty-cart">
                    <p>Votre panier est vide.</p>
                    <a href="présentation.php" class="summary-button">Découvrir nos voyages</a>
                </div>
            <?php else: ?>
                <?php foreach ($cart_items as $cart_item_id => $item): ?>
                    <div class="cart-item">
                        <div class="cart-item-header">
                            <h3>Circuit <?php echo htmlspecialchars($item['circuit_id']); ?></h3>
                            <span>Ajouté le: <?php echo date('d/m/Y', strtotime($item['date_added'])); ?></span>
                        </div>
                        
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
                            
                            <?php if (isset($item['journey_data']['journey_stages']) && !empty($item['journey_data']['journey_stages'])): ?>
                                <p><strong>Étapes:</strong> <?php echo count($item['journey_data']['journey_stages']); ?> étape(s)</p>
                            <?php else: ?>
                                <p><strong>Statut:</strong> 
                                    <?php 
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
                        
                        <div class="cart-actions">
                            <form method="POST">
                                <input type="hidden" name="cart_item_id" value="<?php echo $cart_item_id; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="remove-btn">Supprimer</button>
                            </form>
                            
                            <form method="POST">
                                <input type="hidden" name="cart_item_id" value="<?php echo $cart_item_id; ?>">
                                <input type="hidden" name="action" value="continue_editing">
                                <button type="submit" class="edit-btn">
                                    <?php echo ($item['status'] == 'to_customize') ? 'Personnaliser' : 'Modifier'; ?>
                                </button>
                            </form>
                            
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
                    <a href="#"><img src="../img/twitter.jpg" alt="Twitter"></a>
                    <a href="#"><img src="../img/insta.jpg" alt="Instagram"></a>
                    <a href="#"><img src="../img/linkedin.jpg" alt="LinkedIn"></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 Time Traveler. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
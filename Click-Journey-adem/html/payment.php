<?php
require_once '../php/auth/check_auth.php';
require_once '../php/payment/cybank_utils.php';
requireLogin();

// Vider le panier après un paiement réussi
require_once '../php/cart/cart_functions.php';

if (!isset($_SESSION['circuit_id']) || !isset($_SESSION['date_debut']) || !isset($_SESSION['date_fin'])) {
    header('Location: presentation.php');


    exit();
}

// CY-Bank à voir
$transaction = generateTransactionId();
$montant = $_SESSION['prix_total'] ?? '0.00';
$vendeur = 'MI3_F'; 




$retour_url = 'http://' . $_SERVER['HTTP_HOST'] . '/Click-Journey-adem/php/payment/return_handler.php?session=' . session_id();
$api_key = getAPIKey($vendeur);
$status = 'pending'; 




$control = calculateControlValue($api_key, $transaction, $montant, $vendeur, $status);


$_SESSION['transaction_id'] = $transaction;




$_SESSION['vendeur'] = $vendeur;
?>
<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/payment.css">
    <title>Paiement</title>



    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>
<body>
    <header>
        <div class="logo-conteneur">
            <a href="page-acceuil.php" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
        <div class="header-links">
            <a href="cart.php"><button>Panier</button></a>
            <a href="profil.php"><button>Profil</button></a>
        </div>
    </header>

    <div class="conteneur">



        <div class="payment-container">
            <div class="booking-summary">



                <h2>Récapitulatif de la réservation</h2>
                <div class="summary-details">



                    <p><strong>Circuit :</strong> Circuit <?php echo htmlspecialchars($_SESSION['circuit_id']); ?></p>


                    <p><strong>Date de début :</strong> <?php echo date('d/m/Y', strtotime($_SESSION['date_debut'])); ?></p>
                    <p><strong>Date de fin :</strong> <?php echo date('d/m/Y', strtotime($_SESSION['date_fin'])); ?></p>



                    <p><strong>Montant total :</strong> <?php echo htmlspecialchars($montant); ?> €</p>
                </div>
            </div>


            <form class="payment-form" action="../php/payment/process.php" method="POST">
                <h2>Informations de paiement</h2>



                
                <div class="form-group">


                    <label for="card-name">Nom et prénom du titulaire</label>
                    <input type="text" id="card-name" name="card_name" required>
                </div>

                <div class="form-group">
                    <label for="card-number">Numéro de carte bancaire (16 chiffres)</label>
                    <input type="text" id="card-number" name="card_number" required minlength="16" maxlength="16" pattern="\d{16}">
                </div>

                <div class="form-row">


                    <div class="form-group">


                        <label for="expiry-month">Mois d'expiration</label>


                        <select id="expiry-month" name="expiry_month" required>

                            <?php for($i = 1; $i <= 12; $i++): ?>



                                <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>">


            <?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                                </option>



                            <?php endfor; ?>
                        </select>
 </div>

                    <div class="form-group">
                        <label for="expiry-year">Année d'expiration</label>



          <select id="expiry-year" name="expiry_year" required>
                            <?php 

        $year = date('Y');



             for($i = $year; $i <= $year + 10; $i++): 
                            ?>
                   <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
           </select>
                    </div>

          <div class="form-group">
                        <label for="cvv">Code de sécurité (CVV)</label>
          <input type="text" id="cvv" name="cvv" required minlength="3" maxlength="3" pattern="\d{3}">
                    </div>
                </div>

     <input type="hidden" name="transaction" value="<?php echo htmlspecialchars($transaction); ?>">
                <input type="hidden" name="montant" value="<?php echo htmlspecialchars($montant); ?>">
    <input type="hidden" name="vendeur" value="<?php echo htmlspecialchars($vendeur); ?>">
                
     <button type="submit" class="payment-button">Valider le paiement</button>
            </form>





        </div>
    </div>
</body>
</html>

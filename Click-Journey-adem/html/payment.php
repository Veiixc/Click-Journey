<?php
require_once '../php/auth/check_auth.php';
requireLogin();

// Vérifier si les données de réservation existent en session
if (!isset($_SESSION['circuit_id']) || !isset($_SESSION['date_debut']) || !isset($_SESSION['date_fin'])) {
    header('Location: presentation.php');
    exit();
}
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
                    <p><strong>Nombre de personnes :</strong> <?php echo htmlspecialchars($_SESSION['nb_personnes']); ?></p>
                </div>
            </div>

            <form class="payment-form" action="../php/payment/process.php" method="POST">
                <h2>Informations de paiement</h2>
                
                <div class="form-group">
                    <label for="card-name">Nom et prénom du titulaire</label>
                    <input type="text" id="card-name" name="card_name" required pattern="[A-Za-z\s]+" title="Lettres uniquement">
                </div>

                <div class="form-group card-number-group">
                    <label>Numéro de carte bancaire</label>
                    <div class="card-number-inputs">
                        <input type="text" name="card_number[]" maxlength="4" required pattern="\d{4}">
                        <input type="text" name="card_number[]" maxlength="4" required pattern="\d{4}">
                        <input type="text" name="card_number[]" maxlength="4" required pattern="\d{4}">
                        <input type="text" name="card_number[]" maxlength="4" required pattern="\d{4}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry-month">Mois d'expiration</label>
                        <select id="expiry-month" name="expiry_month" required>
                            <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="expiry-year">Année</label>
                        <select id="expiry-year" name="expiry_year" required>
                            <?php 
                            $currentYear = date('Y');
                            for($i = $currentYear; $i <= $currentYear + 10; $i++): 
                            ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cvv">Code de sécurité</label>
                        <input type="text" id="cvv" name="cvv" maxlength="3" required pattern="\d{3}">
                    </div>
                </div>

                <button type="submit" class="payment-button">Confirmer le paiement</button>
            </form>
        </div>
    </div>

    <script src="../js/payment.js"></script>
</body>
</html>

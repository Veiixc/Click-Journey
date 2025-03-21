<?php
session_start();
require_once '../auth/check_auth.php';
requireLogin();

// Simulation de vérification des coordonnées bancaires
function validateCard($cardNumber, $cvv, $expiryMonth, $expiryYear) {
    // Vérifie que tous les segments font 4 chiffres
    foreach ($cardNumber as $segment) {
        if (strlen($segment) !== 4 || !ctype_digit($segment)) {
            return false;
        }
    }
    
    // Vérifie le CVV (3 chiffres)
    if (strlen($cvv) !== 3 || !ctype_digit($cvv)) {
        return false;
    }
    
    // Vérifie la date d'expiration
    $expiryDate = new DateTime("$expiryYear-$expiryMonth-01");
    $today = new DateTime();
    if ($expiryDate < $today) {
        return false;
    }
    
    // Simule une validation réussie avec 90% de chances
    return (rand(1, 100) <= 90);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cardNumber = $_POST['card_number'];
    $cvv = $_POST['cvv'];
    $expiryMonth = $_POST['expiry_month'];
    $expiryYear = $_POST['expiry_year'];
    
    if (validateCard($cardNumber, $cvv, $expiryMonth, $expiryYear)) {
        // Simulation d'une vérification de solde (70% de chances d'avoir assez d'argent)
        if (rand(1, 100) <= 70) {
            // Paiement accepté - enregistrer la transaction
            header('Location: save_transaction.php');
            exit();
        } else {
            // Solde insuffisant
            $_SESSION['payment_error'] = "Solde insuffisant sur le compte. Veuillez utiliser une autre carte ou modifier votre réservation.";
            header('Location: /Click-Journey-adem/html/payment_error.php');
            exit();
        }
    } else {
        // Coordonnées bancaires invalides
        $_SESSION['payment_error'] = "Les coordonnées bancaires saisies sont invalides. Veuillez vérifier vos informations.";
        header('Location: /Click-Journey-adem/html/payment_error.php');
        exit();
    }
}

// Redirection par défaut
header('Location: /Click-Journey-adem/html/payment.php');
exit();

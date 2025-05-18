<?php
// Démarrage de la session et vérification de l'authentification
session_start();
require_once '../auth/check_auth.php';
requireLogin();


function validateCard($cardNumber, $cvv, $expiryMonth, $expiryYear) {
    // Validation des segments du numéro de carte
    foreach ($cardNumber as $segment) {



        if (strlen($segment) !== 4 || !ctype_digit($segment)) {
            // Segment invalide: doit contenir exactement 4 chiffres
            
            return false;
        }
    }
    
    // Vérification du code CVV
    if (strlen($cvv) !== 3 || !ctype_digit($cvv)) {
        // CVV invalide: doit contenir exactement 3 chiffres
        
        
        return false;
    }
   
    // Vérification de la date d'expiration
    $expiryDate = new DateTime("$expiryYear-$expiryMonth-01");
    
    
    $today = new DateTime();
    if ($expiryDate < $today) {
        // Carte expirée

        return false;
    }
    

    // Simulation d'une validation avec 90% de chances de succès
    return (rand(1, 100) <= 90);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traitement du formulaire de paiement


    // Récupération des données de la carte
    $cardNumber = $_POST['card_number'];
    
    
    $cvv = $_POST['cvv'];
    $expiryMonth = $_POST['expiry_month'];
    
    
    
    $expiryYear = $_POST['expiry_year'];



    
    if (validateCard($cardNumber, $cvv, $expiryMonth, $expiryYear)) {
        // Carte valide, on vérifie maintenant le solde
        if (rand(1, 100) <= 70) {
            // Paiement accepté (70% de chances)


            header('Location: save_transaction.php');



            exit();
        } else {
            // Solde insuffisant (30% de chances)
            
            $_SESSION['payment_error'] = "Solde insuffisant sur le compte. Veuillez utiliser une autre carte ou modifier votre réservation.";
            header('Location: /Click-Journey-adem/html/payment_error.php');




            exit();
        }
    } else {
        // Carte invalide
        $_SESSION['payment_error'] = "Les coordonnées bancaires saisies sont invalides. Veuillez vérifier vos informations.";




        header('Location: /Click-Journey-adem/html/payment_error.php');


        exit();
    }
}




// Redirection par défaut si aucun formulaire n'a été soumis
header('Location: /Click-Journey-adem/html/payment.php');



exit();

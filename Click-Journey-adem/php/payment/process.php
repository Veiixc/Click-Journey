<?php
session_start();
require_once '../auth/check_auth.php';
requireLogin();


function validateCard($cardNumber, $cvv, $expiryMonth, $expiryYear) {
 
    foreach ($cardNumber as $segment) {



        if (strlen($segment) !== 4 || !ctype_digit($segment)) {
            
            
            return false;
        }
    }
    

    if (strlen($cvv) !== 3 || !ctype_digit($cvv)) {
        
        
        
        return false;
    }
   
    $expiryDate = new DateTime("$expiryYear-$expiryMonth-01");
    
    
    $today = new DateTime();
    if ($expiryDate < $today) {


        return false;
    }
    


  
    return (rand(1, 100) <= 90);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    $cardNumber = $_POST['card_number'];
    
    
    $cvv = $_POST['cvv'];
    $expiryMonth = $_POST['expiry_month'];
    
    
    
    $expiryYear = $_POST['expiry_year'];



    
    if (validateCard($cardNumber, $cvv, $expiryMonth, $expiryYear)) {
        
        if (rand(1, 100) <= 70) {
        


            header('Location: save_transaction.php');



            exit();
        } else {
            
            
            $_SESSION['payment_error'] = "Solde insuffisant sur le compte. Veuillez utiliser une autre carte ou modifier votre réservation.";
            header('Location: /Click-Journey-adem/html/payment_error.php');




            exit();
        }
    } else {
       
        $_SESSION['payment_error'] = "Les coordonnées bancaires saisies sont invalides. Veuillez vérifier vos informations.";




        header('Location: /Click-Journey-adem/html/payment_error.php');


        exit();
    }
}




header('Location: /Click-Journey-adem/html/payment.php');



exit();

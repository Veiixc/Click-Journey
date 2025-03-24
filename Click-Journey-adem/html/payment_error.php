<?php
require_once '../php/auth/check_auth.php';
requireLogin();





$error_message = $_SESSION['payment_error'] ?? "Une erreur est survenue lors du paiement, veulez reassayez plus tard.";




unset($_SESSION['payment_error']); 
?>


<!DOCTYPE html>


<html lang="en">
<head>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/payment.css">
    <title>Erreur de paiement</title>



    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>
<body>
    <header>
        <div class="logo-conteneur">
            <a href="page-acceuil.php" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
    </header>

    <div class="conteneur">
        <div class="payment-container">



            <div class="error-message" style="background-color: #fee; padding: 20px; border-radius: 5px; margin-bottom: 20px; color: #c00;">
                <h2>Échec du paiement</h2>
                <p><?php echo htmlspecialchars($error_message); ?></p>



            </div>



            <div class="error-actions" style="display: flex; gap: 20px; justify-content: center;">


                <a href="payment.php" class="summary-button">
                    Réessayer le paiement



                </a>
                <a href="reservation.php?circuit=<?php echo $_SESSION['circuit_id']; ?>" class="summary-button secondary">



                
                    Modifier les options du voyage
                </a>
            </div>
        </div>
    </div>
</body>
</html>

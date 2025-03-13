<?php
session_start();
require_once '../php/check_session.php';
requireLogin();

$transaction_id = $_GET['transaction_id'] ?? null;
if (!$transaction_id) {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="css/paiement.css">
    <title>Confirmation de paiement</title>
</head>
<body>
    <div class="conteneur-paiement">
        <div class="confirmation-message">
            <h2>Paiement confirmé !</h2>
            <p>Votre transaction (<?= htmlspecialchars($transaction_id) ?>) a été effectuée avec succès.</p>
            <p>Un email de confirmation vous a été envoyé.</p>
            <a href="../profil.html" class="btn-payer">Voir mes voyages</a>
        </div>
    </div>
</body>
</html>

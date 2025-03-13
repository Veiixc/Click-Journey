<?php
session_start();
$voyage_id = $_GET['voyage_id'] ?? null;
$error = $_GET['error'] ?? 'unknown';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="css/paiement.css">
    <title>Erreur de paiement</title>
</head>
<body>
    <div class="conteneur-paiement">
        <div class="erreur-message">
            <h2>Une erreur est survenue</h2>
            <p>Votre paiement n'a pas pu être traité.</p>
            <div class="boutons-action">
                <a href="paiement.html?voyage_id=<?= htmlspecialchars($voyage_id) ?>" class="btn-payer">Réessayer</a>
                <a href="../recherche.html" class="btn-secondaire">Retour à la recherche</a>
            </div>
        </div>
    </div>
</body>
</html>

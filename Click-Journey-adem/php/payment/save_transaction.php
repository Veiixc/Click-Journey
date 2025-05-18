<?php
// Démarrage de la session et inclusion des fichiers nécessaires
session_start();
require_once '../auth/check_auth.php';
require_once '../cart/cart_functions.php';
requireLogin(); // Vérification que l'utilisateur est connecté

// Vérification que les données de réservation existent
if (!isset($_SESSION['circuit_id']) || !isset($_SESSION['journey_stages'])) {
    header('Location: /Click-Journey-adem/html/presentation.php');
    exit();
}

// Préparation des données de la transaction
$transaction = [
    'user_id'         => $_SESSION['user_id'],
    'circuit_id'      => $_SESSION['circuit_id'],
    'date_reservation' => date('Y-m-d'),
    'stages'          => json_encode($_SESSION['journey_stages'])
];

// Enregistrement de la transaction dans le fichier CSV
$csvFile = __DIR__ . '/../data/reservations.csv';
$isNewFile = !file_exists($csvFile);
$fp = fopen($csvFile, 'a');

// Ajout des en-têtes si le fichier est nouveau
if ($isNewFile) {
    fputcsv($fp, array_keys($transaction));
}

// Écriture de la transaction
fputcsv($fp, $transaction);
fclose($fp);

// Nettoyage des données de session après la réservation
unset($_SESSION['circuit_id']);
unset($_SESSION['journey_stages']);
unset($_SESSION['date_debut']);
unset($_SESSION['date_fin']);
unset($_SESSION['nb_personnes']);

// Vider le panier
clearCart();

// Message de confirmation et redirection vers le profil
$_SESSION['success'] = "Votre réservation a été confirmée avec succès !";

header('Location: /Click-Journey-adem/html/profil.php');
exit();

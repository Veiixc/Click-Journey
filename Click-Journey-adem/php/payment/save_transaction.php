<?php
session_start();
require_once '../auth/check_auth.php';
requireLogin();

// Vérifier que toutes les données nécessaires sont présentes
if (!isset($_SESSION['circuit_id']) || !isset($_SESSION['journey_stages'])) {
    header('Location: /Click-Journey-adem/html/presentation.php');
    exit();
}

// Préparer les données de la transaction
$transaction = [
    'user_id' => $_SESSION['user_id'],
    'circuit_id' => $_SESSION['circuit_id'],
    'date_reservation' => date('Y-m-d'),
    'stages' => json_encode($_SESSION['journey_stages'])
];

// Enregistrer dans le fichier de réservations
$csvFile = __DIR__ . '/../data/reservations.csv';
$isNewFile = !file_exists($csvFile);

$fp = fopen($csvFile, 'a');

// Si nouveau fichier, écrire les en-têtes
if ($isNewFile) {
    fputcsv($fp, array_keys($transaction));
}

// Écrire la transaction
fputcsv($fp, $transaction);
fclose($fp);

// Nettoyer les données de session liées à la réservation
unset($_SESSION['circuit_id']);
unset($_SESSION['journey_stages']);
unset($_SESSION['date_debut']);
unset($_SESSION['date_fin']);
unset($_SESSION['nb_personnes']);

// Rediriger vers le profil avec message de succès
$_SESSION['success'] = "Votre réservation a été confirmée avec succès !";
header('Location: /Click-Journey-adem/html/profil.php');
exit();

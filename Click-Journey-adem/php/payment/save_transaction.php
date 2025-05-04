<?php
session_start();
require_once '../auth/check_auth.php';
require_once '../cart/cart_functions.php';
requireLogin();

if (!isset($_SESSION['circuit_id']) || !isset($_SESSION['journey_stages'])) {
    header('Location: /Click-Journey-adem/html/presentation.php');
    exit();
}

$transaction = [
    'user_id'         => $_SESSION['user_id'],
    'circuit_id'      => $_SESSION['circuit_id'],
    'date_reservation' => date('Y-m-d'),
    'stages'          => json_encode($_SESSION['journey_stages'])
];

$csvFile = __DIR__ . '/../data/reservations.csv';
$isNewFile = !file_exists($csvFile);
$fp = fopen($csvFile, 'a');

if ($isNewFile) {
    fputcsv($fp, array_keys($transaction));
}

fputcsv($fp, $transaction);
fclose($fp);

unset($_SESSION['circuit_id']);
unset($_SESSION['journey_stages']);
unset($_SESSION['date_debut']);
unset($_SESSION['date_fin']);
unset($_SESSION['nb_personnes']);

clearCart();

$_SESSION['success'] = "Votre réservation a été confirmée avec succès !";

header('Location: /Click-Journey-adem/html/profil.php');
exit();

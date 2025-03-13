<?php
session_start();
require_once '../php/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $card_number = $_POST['card_number_1'] . $_POST['card_number_2'] . $_POST['card_number_3'] . $_POST['card_number_4'];
    $card_holder = $_POST['card_holder'];
    $expiry_month = $_POST['expiry_month'];
    $expiry_year = $_POST['expiry_year'];
    $cvv = $_POST['cvv'];
    $voyage_id = $_POST['voyage_id'];

    // Simulation de vérification bancaire
    $payment_success = verifierPaiement($card_number, $expiry_month, $expiry_year, $cvv);

    if ($payment_success) {
        // Enregistrer la transaction
        $transaction_id = enregistrerTransaction($_SESSION['user_id'], $voyage_id, $card_number);
        header('Location: confirmation.php?transaction_id=' . $transaction_id);
    } else {
        header('Location: erreur_paiement.php?error=payment_failed&voyage_id=' . $voyage_id);
    }
    exit();
}

function verifierPaiement($card_number, $expiry_month, $expiry_year, $cvv) {
    // Simulation - En réalité, vous utiliseriez une API de paiement
    return strlen($card_number) === 16 && strlen($cvv) === 3;
}

function enregistrerTransaction($user_id, $voyage_id, $card_number) {
    $transaction = [
        'id' => uniqid(),
        'user_id' => $user_id,
        'voyage_id' => $voyage_id,
        'card_last_4' => substr($card_number, -4),
        'date' => date('Y-m-d H:i:s'),
        'status' => 'completed'
    ];
    
    // Sauvegarder dans un fichier JSON
    $transactions = json_decode(file_get_contents('../data/transactions.json'), true) ?? [];
    $transactions[] = $transaction;
    file_put_contents('../data/transactions.json', json_encode($transactions));
    
    return $transaction['id'];
}
?>

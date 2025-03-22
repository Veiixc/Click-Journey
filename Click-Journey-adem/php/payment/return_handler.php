<?php
session_start();
require_once __DIR__ . '/cybank_utils.php';

// Vérifier les paramètres reçus
$transaction = $_GET['transaction'] ?? '';
$montant = $_GET['montant'] ?? '';
$vendeur = $_GET['vendeur'] ?? '';
$status = $_GET['status'] ?? '';
$control = $_GET['control'] ?? '';

// Vérifier l'intégrité des données
$api_key = getAPIKey($vendeur);
$expected_control = verifyReturnControl($api_key, $transaction, $montant, $vendeur, $status);

if ($control !== $expected_control || $transaction !== $_SESSION['transaction_id']) {
    $_SESSION['payment_error'] = "Une erreur est survenue lors de la vérification du paiement.";
    header('Location: /Click-Journey-adem/html/payment_error.php');
    exit();
}

if ($status === 'accepted') {
    // Enregistrer la transaction dans la base de données
    try {
        require_once __DIR__ . '/../database/db_connect.php';
        
        $stmt = $pdo->prepare("INSERT INTO transactions (transaction_id, user_id, circuit_id, montant, date_debut, date_fin, nb_personnes, status) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $transaction,
            $_SESSION['user_id'],
            $_SESSION['circuit_id'],
            $montant,
            $_SESSION['date_debut'],
            $_SESSION['date_fin'],
            $_SESSION['nb_personnes'],
            'completed'
        ]);

        // Rediriger vers une page de confirmation
        header('Location: /Click-Journey-adem/html/confirmation.php');
    } catch (PDOException $e) {
        $_SESSION['payment_error'] = "Erreur lors de l'enregistrement de la transaction.";
        header('Location: /Click-Journey-adem/html/payment_error.php');
    }
} else {
    $_SESSION['payment_error'] = "Le paiement a été refusé. Veuillez vérifier vos informations ou essayer une autre carte.";
    header('Location: /Click-Journey-adem/html/payment_error.php');
}

exit();

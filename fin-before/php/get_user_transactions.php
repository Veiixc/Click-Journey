<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non authentifié']);
    exit();
}

$transactions = json_decode(file_get_contents('../data/transactions.json'), true);
$userTransactions = array_filter($transactions, function($t) {
    return $t['user_id'] === $_SESSION['user_id'];
});

header('Content-Type: application/json');
echo json_encode(['transactions' => array_values($userTransactions)]);
?>

<?php
session_start();
require_once '../auth/check_auth.php';
require_once 'cart_functions.php';
requireLogin();

$is_auto = isset($_GET['auto']) && $_GET['auto'] == '1';

if ($is_auto) {
    header('Content-Type: application/json');
}

if (!isset($_GET['circuit_id'])) {
    if ($is_auto) {
        echo json_encode(['success' => false, 'message' => 'ID de circuit manquant']);
        exit();
    } else {
        header('Location: /Click-Journey-adem/html/présentation.php');
        exit();
    }
}

$circuit_id = $_GET['circuit_id'];

$circuits = [
    1 => ['prix' => 4789, 'duree' => 15],
    2 => ['prix' => 5989, 'duree' => 20],
    3 => ['prix' => 2289, 'duree' => 11],
    4 => ['prix' => 1800, 'duree' => 8],
    5 => ['prix' => 3999, 'duree' => 13],
    6 => ['prix' => 2999, 'duree' => 10],
    7 => ['prix' => 4299, 'duree' => 16],
    8 => ['prix' => 3499, 'duree' => 12],
    9 => ['prix' => 4599, 'duree' => 14],
    10 => ['prix' => 1999, 'duree' => 7],
    11 =>   ['prix' => 2599, 'duree' => 9],
    12 => ['prix' => 4999, 'duree' =>   16],
    13 => ['prix' => 5499, 'duree' => 18],
    14 => ['prix' => 5999, 'duree' => 21],
    15 => ['prix' => 4899, 'duree' => 18],
    16 => ['prix' => 3999, 'duree' => 14],
    17 =>   ['prix' => 3799, 'duree' => 15]
];

$circuit_info = isset($circuits[$circuit_id]) ? $circuits[$circuit_id] : [];

$cart_items = getCartItems();
$existing_item_id = null;

foreach ($cart_items as $item_id => $item) {
    if ($item['circuit_id'] == $circuit_id && $item['status'] == 'in_progress') {
        $existing_item_id = $item_id;
        break;
    }
}

if (!$existing_item_id) {
    $cart_item_id = addCircuitToCart($circuit_id, $circuit_info);
    
    if (!$is_auto) {
        $_SESSION['success'] = "Circuit $circuit_id ajouté au panier. Vous pouvez maintenant le personnaliser.";
    }
} else {
    $cart_item_id = $existing_item_id;
}

if ($is_auto) {
    echo json_encode([
        'success' => true, 
        'message' =>   'Circuit ajouté au panier',
        'cart_item_id' =>   $cart_item_id
    ]);
    exit();
}

if (isset($_GET['redirect']) && $_GET['redirect'] == 'customize') {
    header('Location: /Click-Journey-adem/html/reservation.php?circuit=' . $circuit_id);
} else {
    header('Location: /Click-Journey-adem/html/cart.php');
}
exit();
?> 
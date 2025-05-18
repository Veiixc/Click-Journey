<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
require_once '../auth/check_auth.php'; // Inclut les fonctions d'authentification
require_once 'cart_functions.php'; // Inclut les fonctions du panier
requireLogin(); // Force l'utilisateur à être connecté

$is_auto = isset($_GET['auto']) && $_GET['auto'] == '1'; // Vérifie si l'ajout est automatique (via JavaScript)

if ($is_auto) {
    header('Content-Type: application/json'); // Configure l'en-tête pour retourner du JSON
}

if (!isset($_GET['circuit_id'])) { // Vérifie si l'ID du circuit est fourni
    if ($is_auto) {
        echo json_encode(['success' => false, 'message' => 'ID de circuit manquant']); // Erreur en JSON pour les requêtes auto
        exit();
    } else {
        header('Location: /Click-Journey-adem/html/présentation.php'); // Redirige vers la page des circuits
        exit();
    }
}

$circuit_id = $_GET['circuit_id']; // Récupère l'ID du circuit

$circuits = [ // Liste des circuits avec leur prix et durée
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

$circuit_info = isset($circuits[$circuit_id]) ? $circuits[$circuit_id] : []; // Récupère les infos du circuit ou tableau vide

$cart_items = getCartItems(); // Récupère tous les éléments du panier
$existing_item_id = null; // Initialise l'ID d'élément existant

foreach ($cart_items as $item_id => $item) { // Parcourt le panier
    if ($item['circuit_id'] == $circuit_id && $item['status'] == 'in_progress') { // Vérifie si le circuit est déjà dans le panier
        $existing_item_id = $item_id; // Stocke l'ID de l'élément existant
        break;
    }
}

if (!$existing_item_id) { // Si le circuit n'est pas déjà dans le panier
    $cart_item_id = addCircuitToCart($circuit_id, $circuit_info); // Ajoute le circuit au panier
    
    if (!$is_auto) { // Si l'ajout n'est pas automatique
        $_SESSION['success'] = "Circuit $circuit_id ajouté au panier. Vous pouvez maintenant le personnaliser."; // Message de succès
    }
} else {
    $cart_item_id = $existing_item_id; // Utilise l'ID existant
}

if ($is_auto) { // Si la requête est automatique (AJAX)
    echo json_encode([
        'success' => true, 
        'message' =>   'Circuit ajouté au panier',
        'cart_item_id' =>   $cart_item_id
    ]); // Retourne la réponse JSON
    exit();
}

if (isset($_GET['redirect']) && $_GET['redirect'] == 'customize') { // Vérifie où rediriger l'utilisateur
    header('Location: /Click-Journey-adem/html/reservation.php?circuit=' . $circuit_id); // Redirige vers la page de personnalisation
} else {
    header('Location: /Click-Journey-adem/html/cart.php'); // Redirige vers le panier
}
exit();
?> 
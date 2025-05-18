<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
require_once '../auth/check_auth.php'; // Inclut les fonctions d'authentification
require_once 'cart_functions.php'; // Inclut les fonctions du panier

header('Content-Type: application/json'); // Configure l'en-tête pour retourner du JSON

if (!isset($_GET['circuit_id'])) { // Vérifie si l'ID du circuit est fourni
    echo json_encode([
        'success' => false,
        'message' => 'ID du circuit manquant'
    ]); // Retourne une erreur en JSON
    exit();
}

$circuit_id = $_GET['circuit_id']; // Récupère l'ID du circuit

// Vérifier si l'utilisateur est connecté
if (!isLoggedIn()) { // Si l'utilisateur n'est pas connecté
    echo json_encode([
        'success' => false,
        'in_cart' => false,
        'message' => 'Utilisateur non connecté'
    ]); // Retourne un message d'erreur
    exit();
}

// Initialiser le panier
initCart(); // S'assure que le panier est initialisé

$cart_items = getCartItems(); // Récupère tous les éléments du panier
$in_cart = false; // Par défaut, le circuit n'est pas dans le panier
$cart_item_id = null; // ID de l'élément dans le panier (si trouvé)

// Vérifier si le circuit est déjà dans le panier
foreach ($cart_items as $item_id => $item) { // Parcourt tous les éléments du panier
    if ($item['circuit_id'] == $circuit_id && $item['status'] == 'in_progress') { // Vérifie si c'est le même circuit et qu'il est en cours
        $in_cart = true; // Le circuit est dans le panier
        $cart_item_id = $item_id; // Stocke l'ID de l'élément
        break;
    }
}

echo json_encode([
    'success' => true,
    'in_cart' => $in_cart,
    'cart_item_id' => $cart_item_id
]); // Retourne le résultat de la vérification
?> 
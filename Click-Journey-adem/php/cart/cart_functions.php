<?php
// Vérification et démarrage de la session si nécessaire
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Démarre une session si ce n'est pas déjà fait
}
require_once __DIR__ . '/../auth/check_auth.php'; // Importe les fonctions d'authentification

// Définition de la durée de vie du cookie (30 jours en secondes)
define('COOKIE_LIFETIME', 60 * 60 * 24 * 30); // 30 jours - Durée de vie du cookie en secondes

/**
 * Initialise le panier de l'utilisateur
 */
/**
 * Initialise le panier de l'utilisateur
 * Crée un panier vide ou restaure celui sauvegardé dans un cookie
 */
function initCart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Crée un panier vide si aucun n'existe
        
        // Récupère le panier sauvegardé dans un cookie si l'utilisateur est connecté
        if (isLoggedIn() && isset($_COOKIE['saved_cart'])) {
            $saved_cart = json_decode($_COOKIE['saved_cart'], true);
            if (is_array($saved_cart) && !empty($saved_cart)) {
                $_SESSION['cart'] = $saved_cart; // Restaure le panier depuis le cookie
                setcookie('saved_cart', '', time() - 3600, '/'); // Supprime le cookie après restauration
            }
        }
    }
}

/**
 * Sauvegarde le panier dans un cookie
 * @return bool Succès de la sauvegarde
 */
function saveCartToCookie() {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        error_log("saveCartToCookie - Sauvegarde du panier dans un cookie");
        
        $cart_size = count($_SESSION['cart']);
        error_log("saveCartToCookie - Nombre d'éléments dans le panier: $cart_size");
        
        $cart_json = json_encode($_SESSION['cart']); // Convertit le panier en JSON
        $cookie_success = setcookie('saved_cart', $cart_json, time() + COOKIE_LIFETIME, '/'); // Crée un cookie qui dure 30 jours
        
        error_log("saveCartToCookie - Résultat de la sauvegarde: " . ($cookie_success ? "Succès" : "Échec"));
        return $cookie_success;
    }
    return false;
}

/**
 * Ajoute un circuit au panier avec ses données de voyage
 * @param string $circuit_id ID du circuit
 * @param array $journey_data Données du voyage
 * @return string ID de l'élément ajouté au panier
 */
function addToCart($circuit_id, $journey_data) {
    requireLogin(); // Vérifie que l'utilisateur est connecté
    initCart(); // Initialise le panier si nécessaire
    
    $cart_item_id = uniqid('cart_'); // Génère un ID unique pour cet article du panier
    
    error_log("addToCart - Ajout du circuit $circuit_id au panier, ID: $cart_item_id");
    
    $_SESSION['cart'][$cart_item_id] = [
        'circuit_id'   => $circuit_id,
        'date_added'   => date('Y-m-d H:i:s'), // Date d'ajout au panier
        'journey_data' => $journey_data,
        'status'       => 'in_progress' // Statut initial: en cours de personnalisation
    ];
    
    saveCartToCookie(); // Sauvegarde le panier mis à jour
    return $cart_item_id;
}

/**
 * Ajoute un circuit au panier avec des informations de base
 * @param string $circuit_id ID du circuit
 * @param array $circuit_info Informations du circuit
 * @return string ID de l'élément ajouté au panier
 */
function addCircuitToCart($circuit_id, $circuit_info = []) {
    requireLogin();
    initCart();
    
    $cart_item_id = uniqid('cart_');
    
    $journey_data = [
        'circuit_id'     => $circuit_id,
        'date_debut'     => date('Y-m-d', strtotime('+7 days')), // Date par défaut: dans 7 jours
        'date_fin'       => date('Y-m-d', strtotime('+' . ($circuit_info['duree'] ?? 15) . ' days')), // Fin en fonction de la durée ou 15 jours par défaut
        'nb_personnes'   => 1, // Une personne par défaut
        'prix_total'     => $circuit_info['prix'] ?? 0,
        'journey_stages' => [] // Aucune étape pour l'instant
    ];
    
    $_SESSION['cart'][$cart_item_id] = [
        'circuit_id'   => $circuit_id,
        'date_added'   => date('Y-m-d H:i:s'),
        'journey_data' => $journey_data,
        'status'       => 'to_customize' // Statut: à personnaliser
    ];
    
    saveCartToCookie();
    return $cart_item_id;
}

/**
 * Met à jour un élément du panier
 * @param string $cart_item_id ID de l'élément du panier
 * @param array $journey_data Nouvelles données du voyage
 * @return bool Succès de la mise à jour
 */
function updateCartItem($cart_item_id, $journey_data) {
    requireLogin();
    initCart();
    
    if (isset($_SESSION['cart'][$cart_item_id])) { // Vérifie si cet élément existe dans le panier
        error_log("updateCartItem - Mise à jour de l'élément $cart_item_id");
        
        // Vérifie le nombre de personnes pour le journal
        if (isset($journey_data['nb_personnes'])) {
            error_log("updateCartItem - Nombre de personnes: " . $journey_data['nb_personnes']);
        }
        
        // Met à jour les données du voyage
        $_SESSION['cart'][$cart_item_id]['journey_data'] = $journey_data;
        $_SESSION['cart'][$cart_item_id]['last_updated'] = date('Y-m-d H:i:s'); // Horodatage de la mise à jour
        
        saveCartToCookie();
        return true;
    }
    
    return false; // Échec: élément non trouvé
}

/**
 * Supprime un élément du panier
 * @param string $cart_item_id ID de l'élément du panier
 * @return bool Succès de la suppression
 */
function removeFromCart($cart_item_id) {
    requireLogin();
    initCart();
    
    if (isset($_SESSION['cart'][$cart_item_id])) {
        unset($_SESSION['cart'][$cart_item_id]); // Supprime l'élément du panier
        saveCartToCookie();
        return true;
    }
    
    return false;
}

/**
 * Récupère tous les éléments du panier
 * @return array Éléments du panier
 */
function getCartItems() {
    requireLogin();
    initCart();
    return $_SESSION['cart'];
}

/**
 * Marque un élément du panier comme prêt pour le paiement
 * @param string $cart_item_id ID de l'élément du panier
 * @return bool Succès de l'opération
 */
function setCartItemReadyToPay($cart_item_id) {
    requireLogin();
    initCart();
    
    if (isset($_SESSION['cart'][$cart_item_id])) {
        $_SESSION['cart'][$cart_item_id]['status'] = 'ready_to_pay'; // Change le statut pour indiquer qu'il est prêt au paiement
        saveCartToCookie();
        return true;
    }
    
    return false;
}

/**
 * Vide le panier
 */
function clearCart() {
    requireLogin();
    $_SESSION['cart'] = []; // Réinitialise le panier à un tableau vide
    setcookie('saved_cart', '', time() - 3600, '/'); // Supprime aussi le cookie
}

/**
 * Récupère le nombre d'éléments dans le panier
 * @return int Nombre d'éléments
 */
function getCartItemCount() {
    requireLogin();
    initCart();
    return count($_SESSION['cart']); // Compte le nombre d'articles dans le panier
}
?>
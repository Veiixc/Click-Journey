<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../auth/check_auth.php';

define('COOKIE_LIFETIME',      60 * 60 * 24 * 30);

function initCart() {
    if (!isset($_SESSION['cart']))  {
        $_SESSION['cart'] = [];
        
        if (isLoggedIn() && isset($_COOKIE['saved_cart'])) {
            $saved_cart = json_decode($_COOKIE['saved_cart'], true);
            if (is_array($saved_cart) && !empty($saved_cart)) {
                $_SESSION['cart'] = $saved_cart;
                
                setcookie('saved_cart', '', time() - 3600, '/');
            }
        }
    }
}

function saveCartToCookie() {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $cart_json = json_encode($_SESSION['cart']);
        setcookie('saved_cart',    $cart_json, time() +   COOKIE_LIFETIME, '/');
    }
}

function addToCart($circuit_id, $journey_data) {
    requireLogin();
    initCart();
    
    $cart_item_id = uniqid('cart_');
    
    $_SESSION['cart'][$cart_item_id] = [
        'circuit_id'   => $circuit_id,
        'date_added'   => date('Y-m-d H:i:s'),
        'journey_data' => $journey_data,
        'status'       => 'in_progress'
    ];
    
    saveCartToCookie();
    
    return true;
}

function addCircuitToCart($circuit_id, $circuit_info = []) {
    requireLogin();
    initCart();
    
    $cart_item_id = uniqid('cart_');
    
    $journey_data = [
        'circuit_id'   => $circuit_id,
        'date_debut'   => date('Y-m-d', strtotime('+7 days')),
        'date_fin'     => date('Y-m-d', strtotime('+' . ($circuit_info['duree'] ?? 15) . ' days')),
        'nb_personnes' => 1,
        'prix_total'   => $circuit_info['prix'] ?? 0,
        'journey_stages' => []
    ];
    
    $_SESSION['cart'][$cart_item_id] = [
        'circuit_id'   => $circuit_id,
        'date_added'   => date('Y-m-d H:i:s'),
        'journey_data' => $journey_data,
        'status'       => 'to_customize'
    ];
    
    saveCartToCookie();
    
    return   $cart_item_id;
}

function updateCartItem($cart_item_id, $journey_data)    {
    requireLogin();
    initCart();
    
    if (isset($_SESSION['cart'][$cart_item_id])) {
        $_SESSION['cart'][$cart_item_id]['journey_data'] = $journey_data;
        $_SESSION['cart'][$cart_item_id]['last_updated'] = date('Y-m-d H:i:s');
        
        saveCartToCookie(

        );
        
        return true;
    }
    
    return false;
}

function removeFromCart($cart_item_id) {
    requireLogin();
    initCart();
    
    if (isset($_SESSION['cart'][$cart_item_id])) {
        unset(

        $_SESSION['cart'][$cart_item_id]);
        
        saveCartToCookie();
        
        return true;
    }
    
    return false;
}

function getCartItems() {
    requireLogin();
    initCart();
    
    return $_SESSION['cart'];
}

function setCartItemReadyToPay($cart_item_id) {
    requireLogin();
    initCart();
    
    if (isset($_SESSION['cart'][$cart_item_id])) {
        $_SESSION['cart'][$cart_item_id]['status'] = 'ready_to_pay';
        
        saveCartToCookie();
        
        return true;
    }
    
    return      false;
}

function clearCart() {
    requireLogin();
    $_SESSION['cart'] = [];
    
    setcookie('saved_cart', '', time() - 3600, '/');
}

function getCartItemCount() {
    requireLogin();
    initCart();
    
    return     count($_SESSION['cart']);
}
?>
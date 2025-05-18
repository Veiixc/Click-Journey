<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
require_once '../auth/check_auth.php'; // Inclut les fonctions d'authentification
require_once 'cart_functions.php'; // Inclut les fonctions du panier
requireLogin(); // Force l'utilisateur à être connecté

header('Content-Type: application/json'); // Configure la réponse en JSON

// Activation de la journalisation des erreurs
error_log("get_saved_options.php - Début du traitement"); // Log de début de traitement

if (!isset($_GET['circuit_id'])) { // Vérifie si l'ID du circuit est fourni
    echo json_encode([
        'success' => false,
        'message' => 'ID du circuit manquant'
    ]); // Renvoie une erreur si l'ID est manquant
    exit();
}

$circuit_id = $_GET['circuit_id']; // Récupère l'ID du circuit
error_log("get_saved_options.php - Recherche des options pour le circuit: " . $circuit_id); // Log de l'ID du circuit

// Récupérer tous les éléments du panier
$cart_items = getCartItems(); // Récupère tous les éléments du panier
$found_item = null; // Initialise l'élément trouvé
$cart_item_id = null; // Initialise l'ID de l'élément

// Si un cart_item_id spécifique est fourni, chercher directement cet élément
if (isset($_GET['cart_item_id']) && !empty($_GET['cart_item_id'])) { // Si un ID d'élément est fourni
    $cart_item_id = $_GET['cart_item_id']; // Récupère l'ID fourni
    
    if (isset($cart_items[$cart_item_id])) { // Si l'élément existe dans le panier
        $found_item = $cart_items[$cart_item_id]; // Récupère l'élément
        error_log("get_saved_options.php - Élément spécifique du panier trouvé: " . $cart_item_id); // Log de l'élément trouvé
    } else {
        error_log("get_saved_options.php - ATTENTION: ID d'élément du panier fourni mais non trouvé: " . $cart_item_id); // Log d'alerte
    }
}

// Si l'élément n'a pas été trouvé par ID, chercher par circuit_id
if (!$found_item) { // Si aucun élément n'a été trouvé
    foreach ($cart_items as $item_id => $item) { // Parcourt tous les éléments du panier
        if ($item['circuit_id'] == $circuit_id) { // Si c'est le bon circuit
            $found_item = $item; // Récupère l'élément
            $cart_item_id = $item_id; // Récupère l'ID
            error_log("get_saved_options.php - Circuit trouvé dans le panier, ID: " . $item_id); // Log de l'élément trouvé
            break;
        }
    }
}

if ($found_item) { // Si un élément a été trouvé
    // Vérifier et nettoyer les données du voyage
    if (isset($found_item['journey_data']) && is_array($found_item['journey_data'])) { // Si les données du voyage existent et sont valides
        // Journaliser les données pour le débogage
        error_log("get_saved_options.php - Données du voyage trouvées: " . print_r($found_item['journey_data'], true)); // Log des données trouvées
        
        // Vérifier les données des étapes
        if (isset($found_item['journey_data']['journey_stages']) && is_array($found_item['journey_data']['journey_stages'])) { // Si les étapes existent
            // Vérifier que chaque étape a des données brutes
            foreach ($found_item['journey_data']['journey_stages'] as $key => $stage) { // Pour chaque étape
                if (!isset($stage['raw_data'])) { // Si les données brutes sont manquantes
                    $found_item['journey_data']['journey_stages'][$key]['raw_data'] = [
                        'lodging' => null,
                        'meals' => null,
                        'activities' => [],
                        'transport' => null
                    ]; // Initialise les données brutes
                    error_log("get_saved_options.php - Initialisation des données brutes pour l'étape $key"); // Log de l'initialisation
                }
            }
        }
        
        echo json_encode([
            'success' => true,
            'message' => 'Options trouvées',
            'cart_item' => $found_item,
            'cart_item_id' => $cart_item_id
        ]); // Renvoie les données trouvées
    } else {
        error_log("get_saved_options.php - Données du voyage manquantes ou incorrectes"); // Log d'erreur
        echo json_encode([
            'success' => false,
            'message' => 'Données du voyage mal formatées'
        ]); // Renvoie une erreur de format
    }
} else {
    error_log("get_saved_options.php - Aucune option trouvée pour le circuit " . $circuit_id); // Log d'absence de données
    
    echo json_encode([
        'success' => false,
        'message' => 'Aucune option sauvegardée pour ce circuit'
    ]); // Renvoie un message indiquant qu'aucune option n'a été trouvée
}
?> 
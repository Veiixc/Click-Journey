<?php
session_start();
require_once '../auth/check_auth.php';
require_once 'cart_functions.php';
requireLogin();

header('Content-Type: application/json');

// Activer la journalisation des erreurs
error_log("auto_save_cart.php - Début du traitement");
error_log("auto_save_cart.php - Données reçues: " . print_r($_POST, true));

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['circuit_id'])) {
    error_log("auto_save_cart.php - Erreur: Données incomplètes");
    echo json_encode(['success' => false, 'message' => 'Données incomplètes']);
    exit();
}

try {
    include_once '../stages/get_stages.php';
    
    $circuit_id = $_POST['circuit_id'];
    error_log("auto_save_cart.php - Circuit ID: " . $circuit_id);
    
    // Traitement des dates
    $date_debut = isset($_POST['date_debut']) ? $_POST['date_debut'] : date('Y-m-d');
    $date_fin = isset($_POST['date_fin']) ? $_POST['date_fin'] : date('Y-m-d', strtotime('+7 days'));
    
    // Traitement du nombre de personnes (crucial)
    $nb_personnes = 1; // Valeur par défaut
    if (isset($_POST['nb_personnes'])) {
        $nb_personnes = intval($_POST['nb_personnes']);
        error_log("auto_save_cart.php - Nombre de personnes trouvé dans POST: " . $nb_personnes);
    } else {
        error_log("auto_save_cart.php - ATTENTION: Nombre de personnes non trouvé dans POST!");
        // Dumper tous les champs POST pour débogage
        error_log("auto_save_cart.php - Contenu de POST: " . print_r($_POST, true));
    }
    
    // Traitement du prix total
    $prix_total = isset($_POST['prix_total']) ? floatval($_POST['prix_total']) : 0;
    
    // Récupérer les prix dynamiques des circuits
    $circuit_prices = [
        '1' => 4789,  
        '2' => 5989,  
        '3' => 2289,  
        '4' => 1800,  
        '5' => 3999,  
        '6' => 2999,  
        '7' => 4299,  
        '8' => 3499,  
        '9' => 4599,  
        '10' => 1999, 
        '11' => 2599, 
        '12' => 4999, 
        '13' => 5499, 
        '14' => 5999, 
        '15' => 4899, 
        '16' => 3999, 
        '17' => 3799
    ];
    
    // Si prix total n'est pas fourni, utiliser le prix de base du circuit
    if ($prix_total == 0 && isset($circuit_prices[$circuit_id])) {
        $prix_total = $circuit_prices[$circuit_id];
    }
    
    // S'assurer que nous avons les étapes pour ce circuit
    $circuit_stages = isset($circuits[$circuit_id]) ? $circuits[$circuit_id] : $stages;
    
    $journey_stages = [];
    
    // CORRECTION: Amélioration de la détection des options d'étapes
    // Méthode 1: Recherche des sélecteurs individuels (format: stages[0][lodging], etc.)
    error_log("auto_save_cart.php - Recherche d'options individuelles dans POST");
    
    // Préparer les structures pour chaque étape avec des valeurs par défaut
    foreach ($circuit_stages as $index => $stage) {
        $journey_stages[$index] = [
            'title'      => $stage['title'],
            'lodging'    => '',
            'meals'      => 'Sans repas',
            'activities' => [],
            'transport'  => '',
            'raw_data'   => [
                'lodging'    => null,
                'meals'      => 'none',
                'activities' => [],
                'transport'  => null
            ]
        ];
    }
    
    // Traiter les valeurs POST pour chaque étape
    foreach ($_POST as $key => $value) {
        // Format attendu: stages[0][lodging], stages[0][meals], etc.
        if (preg_match('/^stages\[(\d+)\]\[(\w+)\]$/', $key, $matches)) {
            $stageIndex = intval($matches[1]);
            $optionType = $matches[2];
            error_log("auto_save_cart.php - Option individuelle trouvée: $key = $value");
            
            if (!isset($journey_stages[$stageIndex])) {
                if (!isset($circuit_stages[$stageIndex])) {
                    continue;
                }
                $current_stage = $circuit_stages[$stageIndex];
                
                $journey_stages[$stageIndex] = [
                    'title'      => $current_stage['title'],
                    'lodging'    => '',
                    'meals'      => 'Sans repas',
                    'activities' => [],
                    'transport'  => '',
                    'raw_data'   => []
                ];
            }
            
            $current_stage = $circuit_stages[$stageIndex];
            
            // Mise à jour de l'option spécifique
            switch ($optionType) {
                case 'lodging':
                    $journey_stages[$stageIndex]['raw_data']['lodging'] = $value;
                    foreach ($current_stage['lodging_options'] as $option) {
                        if ($option['id'] === $value) {
                            $journey_stages[$stageIndex]['lodging'] = $option['name'];
                            break;
                        }
                    }
                    break;
                
                case 'meals':
                    $journey_stages[$stageIndex]['raw_data']['meals'] = $value;
                    $meals_translation = [
                        'none'      => 'Sans repas',
                        'breakfast' => 'Petit déjeuner',
                        'half'      => 'Demi-pension',
                        'full'      => 'Pension complète'
                    ];
                    $journey_stages[$stageIndex]['meals'] = isset($meals_translation[$value]) 
                        ? $meals_translation[$value] 
                        : $value;
                    break;
                
                case 'activities':
                    // Les activités peuvent être un tableau ou une valeur unique
                    if (is_array($value)) {
                        $journey_stages[$stageIndex]['raw_data']['activities'] = $value;
                        error_log("auto_save_cart.php - Activités (tableau) pour l'étape $stageIndex: " . implode(', ', $value));
                    } else {
                        // Si c'est une valeur unique, la convertir en tableau
                        $journey_stages[$stageIndex]['raw_data']['activities'] = [$value];
                    }
                    
                    $activity_names = [];
                    foreach ($current_stage['activities'] as $activity) {
                        if (is_array($value)) {
                            if (in_array($activity['id'], $value)) {
                                $activity_names[] = $activity['name'];
                            }
                        } else {
                            if ($activity['id'] === $value) {
                                $activity_names[] = $activity['name'];
                            }
                        }
                    }
                    $journey_stages[$stageIndex]['activities'] = $activity_names;
                    break;
                
                case 'transport':
                    $journey_stages[$stageIndex]['raw_data']['transport'] = $value;
                    foreach ($current_stage['transport_options'] as $option) {
                        if ($option['id'] === $value) {
                            $journey_stages[$stageIndex]['transport'] = $option['name'];
                            break;
                        }
                    }
                    break;
            }
        }
    }
    
    // Méthode 2: Rechercher les activités qui peuvent avoir des valeurs multiples
    // Format: stages[0][activities][], stages[1][activities][], etc.
    foreach ($_POST as $key => $value) {
        if (preg_match('/^stages\[(\d+)\]\[activities\]\[\]$/', $key, $matches)) {
            $stageIndex = intval($matches[1]);
            error_log("auto_save_cart.php - Activité multiple trouvée: $key = " . print_r($value, true));
            
            if (!isset($journey_stages[$stageIndex])) {
                continue;
            }
            
            $current_stage = $circuit_stages[$stageIndex];
            
            // Si c'est un tableau d'activités
            if (is_array($value)) {
                $journey_stages[$stageIndex]['raw_data']['activities'] = $value;
                
                $activity_names = [];
                foreach ($current_stage['activities'] as $activity) {
                    if (in_array($activity['id'], $value)) {
                        $activity_names[] = $activity['name'];
                    }
                }
                $journey_stages[$stageIndex]['activities'] = $activity_names;
            }
        }
    }
    
    // Trier les étapes par index
    ksort($journey_stages);
    $journey_stages = array_values($journey_stages);
    
    // Log des données collectées
    error_log("auto_save_cart.php - Étapes du voyage après traitement: " . print_r($journey_stages, true));
    
    // Créer les données complètes du voyage
    $journey_data = [
        'circuit_id'   => $circuit_id,
        'date_debut'   => $date_debut,
        'date_fin'     => $date_fin,
        'nb_personnes' => $nb_personnes,
        'prix_total'   => $prix_total,
        'journey_stages' => $journey_stages,
        'last_modified' => date('Y-m-d H:i:s')
    ];
    
    error_log("auto_save_cart.php - Données du voyage préparées: nb_personnes = " . $journey_data['nb_personnes']);
    
    // Rechercher un élément existant dans le panier
    $cart_items = getCartItems();
    $existing_item_id = null;

    // Si un cart_item_id est fourni explicitement, l'utiliser en priorité
    if (isset($_POST['cart_item_id']) && isset($cart_items[$_POST['cart_item_id']])) {
        $existing_item_id = $_POST['cart_item_id'];
        error_log("auto_save_cart.php - ID d'élément du panier fourni par POST: " . $existing_item_id);
    } else {
        // Sinon, rechercher par circuit_id comme avant
        foreach ($cart_items as $item_id => $item) {
            if ($item['circuit_id'] == $circuit_id && $item['status'] == 'in_progress') {
                $existing_item_id = $item_id;
                error_log("auto_save_cart.php - Circuit trouvé dans le panier, ID: " . $existing_item_id);
                break;
            }
        }
    }

    // Mettre à jour ou ajouter au panier
    $cart_item_id = null;
    if ($existing_item_id) {
        error_log("auto_save_cart.php - Mise à jour de l'élément du panier: " . $existing_item_id);
        updateCartItem($existing_item_id, $journey_data);
        $cart_item_id = $existing_item_id;
    } else {
        error_log("auto_save_cart.php - Ajout d'un nouvel élément au panier");
        $cart_item_id = addToCart($circuit_id, $journey_data);
    }

    // Vérification après mise à jour
    $updated_cart = getCartItems();
    if ($cart_item_id && isset($updated_cart[$cart_item_id])) {
        error_log("auto_save_cart.php - Vérification après mise à jour: nb_personnes = " . 
                  $updated_cart[$cart_item_id]['journey_data']['nb_personnes']);
    }

    echo json_encode([
        'success' => true, 
        'message' => 'Sauvegardé automatiquement dans le panier',
        'cart_item_id' => $cart_item_id,
        'debug' => [
            'nb_personnes' => $nb_personnes,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'prix_total' => $prix_total
        ]
    ]);
    
    error_log("auto_save_cart.php - Traitement terminé avec succès");
} catch (Exception $e) {
    error_log("auto_save_cart.php - Exception: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?>
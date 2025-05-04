<?php
session_start();
require_once '../auth/check_auth.php';
require_once 'cart_functions.php';
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['circuit_id'])) {
    echo json_encode(['success' => false, 'message' => 'Données incomplètes']);
    exit();
}

try {
    include_once '../stages/get_stages.php';
    
    $circuit_id = $_POST['circuit_id'];
    $date_debut = isset($_POST['date_debut'])     ? $_POST['date_debut'] : date('Y-m-d');
    $date_fin = isset($_POST['date_fin'])     ? $_POST['date_fin'] : date('Y-m-d', strtotime('+7 days'));
    $nb_personnes = isset($_POST['nb_personnes']) ? intval($_POST['nb_personnes'])   : 1;
    $prix_total = isset($_POST['prix_total'])     ? floatval($_POST['prix_total']) : 0;
    
    $journey_stages = [];
    if (isset($_POST['stages']) && is_array($_POST['stages'])) {
        foreach ($_POST['stages'] as $index => $stageData) {
            if (!isset($stages[$index])) continue;
            $current_stage = $stages[$index];
            
            $lodging_name = '';
            if (isset($stageData['lodging']) && !empty($stageData['lodging'])) {
                foreach ($current_stage['lodging_options'] as $option) {
                    if ($option['id'] === $stageData['lodging']) {
                        $lodging_name = $option['name'];
                        break;
                    }
                }
            }
            
            $meals_translation = [
                'none'      => 'Sans repas',
                'breakfast' => 'Petit déjeuner',
                'half'      => 'Demi-pension',
                'full'      => 'Pension complète'
            ];
            $meals_name = isset($stageData['meals']) && isset($meals_translation[$stageData['meals']]) 
                            ? $meals_translation[$stageData['meals']] 
                            : 'Sans repas';
            
            $activity_names = [];
            if (isset($stageData['activities']) && !empty($stageData['activities'])) {
                foreach ($current_stage['activities'] as $activity) {
                    if (in_array($activity['id'], (array)$stageData['activities'])) {
                        $activity_names[] = $activity['name'];
                    }
                }
            }
            
            $transport_name = '';
            if (isset($stageData['transport']) && !empty($stageData['transport'])) {
                foreach ($current_stage['transport_options'] as $option) {
                    if ($option['id'] === $stageData['transport']) {
                        $transport_name = $option['name'];
                        break;
                    }
                }
            }
            
            $journey_stages[] = [
                'title'      => $current_stage['title'],
                'lodging'    => $lodging_name,
                'meals'      => $meals_name,
                'activities' => $activity_names,
                'transport'  => $transport_name
            ];
        }
    }
    
    $journey_data = [
        'circuit_id'   => $circuit_id,
        'date_debut'   => $date_debut,
        'date_fin'     => $date_fin,
        'nb_personnes' => $nb_personnes,
        'prix_total'   => $prix_total,
        'journey_stages' => $journey_stages,
        'last_modified' => date('Y-m-d H:i:s')
    ];
    
    $cart_items = getCartItems();
    $existing_item_id =      null;
    
    foreach ($cart_items as $item_id => $item) {
        if ($item['circuit_id'] == $circuit_id && $item['status'] == 'in_progress') {
            $existing_item_id = $item_id;
            break;
        }
    }
    
    if ($existing_item_id) {
        updateCartItem($existing_item_id, $journey_data);
    } else {
        addToCart($circuit_id, $journey_data);
    }
    
    echo json_encode(['success' =>   true, 'message' => 'Sauvegardé automatiquement dans le panier']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?> 
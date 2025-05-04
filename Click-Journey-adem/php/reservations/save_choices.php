<?php
session_start();
require_once '../auth/check_auth.php';
require_once '../cart/cart_functions.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once '../stages/get_stages.php';
    $_SESSION['date_debut'] = $_POST['date_debut'];
    $_SESSION['date_fin'] = $_POST['date_fin'];
    $_SESSION['nb_personnes'] = intval($_POST['nb_personnes']);
    
    $_SESSION['prix_total'] = isset($_POST['prix_total']) ? floatval($_POST['prix_total']) : 0;
    
    $journey_stages = [];
    foreach ($_POST['stages'] as $index => $stageData) {
        $current_stage = $stages[$index];
        
        $lodging_name = '';
        foreach ($current_stage['lodging_options'] as $option) {
            if ($option['id'] === $stageData['lodging']) {
                $lodging_name = $option['name'];
                break;
            }
        }
        
        $meals_translation = [
            'none'      => 'Sans repas',
            'breakfast' => 'Petit déjeuner',
            'half'      => 'Demi-pension',
            'full'      => 'Pension complète'
        ];
        $meals_name = $meals_translation[$stageData['meals']] ?? $stageData['meals'];
        
        $activity_names = [];
        if (!empty($stageData['activities'])) {
            foreach ($current_stage['activities'] as $activity) {
                if (in_array($activity['id'], (array)$stageData['activities'])) {
                    $activity_names[] = $activity['name'];
                }
            }
        }
        
        $transport_name = '';
        foreach ($current_stage['transport_options'] as $option) {
            if ($option['id'] === $stageData['transport']) {
                $transport_name = $option['name'];
                break;
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

    $journey_data = [
        'circuit_id'   => $_POST['circuit_id'],
        'date_debut'   => $_POST['date_debut'],
        'date_fin'     => $_POST['date_fin'],
        'nb_personnes' => intval($_POST['nb_personnes']),
        'prix_total'   => isset($_POST['prix_total']) ? floatval($_POST['prix_total']) : 0,
        'journey_stages' => $journey_stages
    ];
    
    addToCart($_POST['circuit_id'], $journey_data);
    
    $_SESSION['journey_stages'] = $journey_stages;
    $_SESSION['circuit_id'] = $_POST['circuit_id'];
    
    header('Location: /Click-Journey-adem/html/summary.php');
    exit();
} else {
    header('Location: /Click-Journey-adem/html/presentation.php');
    exit();
}
?>

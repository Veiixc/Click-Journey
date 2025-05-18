<?php
// Activation de la gestion des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoriser les requêtes AJAX
header('Content-Type: application/json');

// Authentification
require_once '../auth/check_auth.php';

// Vérifier si l'utilisateur est connecté sans bloquer
$is_logged_in = isLoggedIn();

// Si on est en mode API (pas de GUI) et que l'utilisateur n'est pas connecté
// on autorise quand même l'accès pour le débogage
if (!$is_logged_in && !isset($_GET['debug'])) {
    requireLogin(); // Redirige si pas connecté
}

// Récupérer l'ID du circuit
$circuit_id = isset($_GET['circuit_id']) ? $_GET['circuit_id'] : null;

if (!$circuit_id) {
    echo json_encode([
        'success' => false,
        'message' => 'ID du circuit manquant'
    ]);
    exit;
}

// Tous les circuits disponibles et leurs options
// Normalement, ces données seraient récupérées depuis une base de données
$circuits = [];

// Inclure les données des circuits
require_once '../stages/get_stages.php';

// Déboguer: vérifier si le circuit 7 est défini
$available_circuits = array_keys($circuits);

// Par défaut, on renvoie les étapes du circuit 1 si elles existent
$stages = isset($stages) ? $stages : [];

// Si un circuit spécifique est demandé et qu'il existe dans notre collection
if (isset($circuits[$circuit_id])) {
    $stages = $circuits[$circuit_id];
}

// Renvoyer les données au format JSON
echo json_encode([
    'success' => true,
    'circuit_id' => $circuit_id,
    'stages' => $stages,
    'debug_info' => [
        'available_circuits' => $available_circuits,
        'circuit_requested' => $circuit_id,
        'circuit_exists' => isset($circuits[$circuit_id]),
        'stages_count' => count($stages),
        'is_logged_in' => $is_logged_in
    ]
]);
?> 
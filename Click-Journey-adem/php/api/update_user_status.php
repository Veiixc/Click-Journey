<?php
header('Content-Type: application/json');

// Vérifier si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer et décoder les données JSON
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Vérifier si les données nécessaires sont présentes
if (!isset($data['user_login']) || !isset($data['action'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit;
}

// Inclure les fonctions nécessaires
require_once '../includes/functions.php';
require_once '../auth/check_auth.php';

// Vérifier si l'utilisateur est administrateur
if (!isAdmin()) {
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit;
}

// Simuler une latence pour voir l'indicateur de chargement (3 secondes)
sleep(3);

// Récupérer les données utilisateur
$user_login = $data['user_login'];
$action = $data['action'];

// Lire le fichier CSV des utilisateurs
$users_file = __DIR__ . '/../data/users.csv';
$users = readCSV($users_file);

// Rechercher l'utilisateur
$user_index = -1;
$user_data = null;

foreach ($users as $index => $user) {
    if ($user['login'] === $user_login) {
        $user_index = $index;
        $user_data = $user;
        break;
    }
}

// Vérifier si l'utilisateur existe
if ($user_index === -1) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
    exit;
}

// Traiter l'action demandée
$new_status = '';

if ($action === 'toggle_vip') {
    // Si l'utilisateur est banni, ne pas permettre de le rendre VIP
    if ($user_data['role'] === 'banned') {
        echo json_encode(['success' => false, 'message' => 'Impossible de rendre VIP un utilisateur banni']);
        exit;
    }
    
    // Basculer entre VIP et utilisateur normal
    if ($user_data['role'] === 'vip') {
        $users[$user_index]['role'] = 'user';
        $new_status = 'user';
    } else {
        $users[$user_index]['role'] = 'vip';
        $new_status = 'vip';
    }
} elseif ($action === 'toggle_ban') {
    // Basculer entre banni et actif
    if ($user_data['role'] === 'banned') {
        $users[$user_index]['role'] = 'user';
        $new_status = 'user';
    } else {
        $users[$user_index]['role'] = 'banned';
        $new_status = 'banned';
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Action non reconnue']);
    exit;
}

// Enregistrer les modifications dans le fichier CSV
if (writeCSV($users_file, $users)) {
    echo json_encode([
        'success' => true, 
        'message' => 'Statut mis à jour avec succès',
        'new_status' => $new_status
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour du statut']);
}
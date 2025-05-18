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
if (!isset($data['user_login']) || !isset($data['field']) || !isset($data['value'])) {
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
$field = $data['field'];
$value = $data['value'];

// Vérifier que le champ est valide
$allowed_fields = ['nom', 'prenom', 'email', 'telephone', 'date_naissance', 'role'];
if (!in_array($field, $allowed_fields)) {
    echo json_encode(['success' => false, 'message' => 'Champ non autorisé']);
    exit;
}

// Validation des données
if ($field === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format d\'email invalide']);
    exit;
}

if ($field === 'role' && !in_array($value, ['user', 'admin', 'vip', 'banned'])) {
    echo json_encode(['success' => false, 'message' => 'Rôle invalide']);
    exit;
}

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

// Mettre à jour le champ
$users[$user_index][$field] = $value;

// Enregistrer les modifications dans le fichier CSV
if (writeCSV($users_file, $users)) {
    echo json_encode([
        'success' => true, 
        'message' => 'Modification appliquée avec succès',
        'updated_data' => $users[$user_index]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
}
<?php
session_start();
include 'database.php';

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('HTTP/1.0 403 Forbidden');
    echo json_encode(['error' => 'Accès non autorisé']);
    exit();
}

// Récupérer les paramètres de pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$usersPerPage = 10;

// Lire tous les utilisateurs
$users = readUsers();
array_shift($users); // Enlever l'en-tête

// Calculer le nombre total de pages
$totalUsers = count($users);
$totalPages = ceil($totalUsers / $usersPerPage);

// Calculer l'offset
$offset = ($page - 1) * $usersPerPage;

// Extraire les utilisateurs pour la page courante
$pageUsers = array_slice($users, $offset, $usersPerPage);

// Préparer la réponse
$response = [
    'users' => $pageUsers,
    'pagination' => [
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'usersPerPage' => $usersPerPage,
        'totalUsers' => $totalUsers
    ]
];

header('Content-Type: application/json');
echo json_encode($response);
?>

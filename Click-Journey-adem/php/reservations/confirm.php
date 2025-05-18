<?php
// Démarrage de la session et vérification de l'authentification
session_start();
require_once '../auth/check_auth.php';

// Vérification que l'utilisateur est connecté
requireLogin();

// Redirection vers la page de paiement
header('Location: /Click-Journey-adem/html/payment.php');
exit(); // Arrêt de l'exécution du script

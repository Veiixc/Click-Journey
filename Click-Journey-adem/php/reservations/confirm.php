<?php
session_start();
require_once '../auth/check_auth.php';
requireLogin();

// Rediriger vers la page de paiement
header('Location: /Click-Journey-adem/html/payment.php');
exit();

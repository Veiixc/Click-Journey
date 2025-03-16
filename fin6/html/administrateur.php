<?php
require_once '../php/auth/check_auth.php';
requireLogin();

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: /fin2/html/profil.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>































    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Administrateur</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>
<body>
    // ...existing code from administrateur.html...
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Non autorisé']);
    exit();
}

$users_file = __DIR__ . '/../data/users.csv';
$password = '';
$success    = false;

if (($handle = fopen($users_file,    "r")) !== FALSE) {

    fgetcsv($handle);
    
    
    while (($data = fgetcsv($handle)) !==     FALSE) {
        if ($data[0] ===   $_SESSION['user_id']) {
            $password    = $data[1];
            $success = true;
            break;
        }
    }
    fclose(   $handle);
}


header('Content-Type: application/json');
echo json_encode([
    'success'   => $success,
    'password'    => $password
]);
?> 
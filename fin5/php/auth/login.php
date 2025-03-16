<?php
session_start();
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = readCSV('../data/users.csv');
    $login = $_POST['login'];
    $password = $_POST['password'];
    
    foreach ($users as $user) {
        if ($user['login'] === $login && $user['password'] === $password) {
            $_SESSION['user_id'] = $login;
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['date_naissance'] = $user['date_naissance'];
            
            echo json_encode(['success' => true, 'role' => $user['role']]);
            exit();
        }
    }
    
    echo json_encode(['success' => false, 'message' => 'Login ou mot de passe incorrect']);
    exit();
}
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            fetch(this.action, {
                method: this.method,
                body: formData
            }).then(response => response.json()).then(data => {
                if (data.success) {
                    if (data.role === 'admin') {
                        window.location.href = '/fin2/html/administrateur.php';
                    } else {
                        window.location.href = '/fin2/html/profil.php';
                    }
                } else {
                    alert(data.message);
                }
            });
        });
    });
</script>

<?php
include 'database.php';

// Lire les utilisateurs existants
$users = readUsers();
$header = array_shift($users); // Sauvegarder l'en-tête

// Mot de passe en clair pour admin1
$admin_password = 'adem';
$admin_hash = password_hash($admin_password, PASSWORD_DEFAULT);

// Chercher et mettre à jour admin1
$admin_found = false;
foreach ($users as $key => $user) {
    if ($user[0] === 'admin1') {
        $users[$key][1] = $admin_hash; // Mettre à jour le hash
        $admin_found = true;
        break;
    }
}

// Si admin1 n'existe pas, l'ajouter
if (!$admin_found) {
    $users[] = [
        'admin1',
        $admin_hash,
        'admin',
        'Admin One',
        'admin1',
        '1980-01-01',
        '123 Admin St',
        date('Y-m-d H:i:s')
    ];
}

// Remettre l'en-tête
array_unshift($users, $header);

// Sauvegarder les modifications
writeUsers($users);

echo "Le mot de passe pour admin1 a été mis à jour avec succès!\n";
echo "Login: admin1\n";
echo "Mot de passe: adem\n";
?>

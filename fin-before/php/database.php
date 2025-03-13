<?php
// Constants for file paths
define('USERS_FILE', __DIR__ . '/../data/users.csv');
define('VOYAGES_FILE', __DIR__ . '/../data/voyages.json');

// Helper functions for file operations
function readUsers() {
    if (!file_exists(USERS_FILE)) {
        return [];
    }
    return array_map('str_getcsv', file(USERS_FILE));
}

function writeUsers($users) {
    // Créer le répertoire data s'il n'existe pas
    if (!file_exists(dirname(USERS_FILE))) {
        mkdir(dirname(USERS_FILE), 0777, true);
    }
    
    // Si le fichier n'existe pas, ajouter l'en-tête
    if (!file_exists(USERS_FILE)) {
        $fp = fopen(USERS_FILE, 'w');
        fputcsv($fp, ['login', 'password', 'role', 'name', 'pseudo', 'birthdate', 'address', 'registration_date']);
        fclose($fp);
    }
    
    // Écrire les utilisateurs
    $fp = fopen(USERS_FILE, 'w');
    foreach ($users as $user) {
        fputcsv($fp, $user);
    }
    fclose($fp);
}

function readVoyages() {
    if (!file_exists(VOYAGES_FILE)) {
        return [];
    }
    return json_decode(file_get_contents(VOYAGES_FILE), true);
}
?>

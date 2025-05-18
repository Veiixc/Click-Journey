<?php
function readCSV($filename) { // Fonction pour lire un fichier CSV et le convertir en tableau associatif
    $rows = array(); // Initialise un tableau vide pour stocker les données
    if (($handle = fopen($filename, "r")) !== FALSE) { // Ouvre le fichier en lecture
        $firstLine = fgets($handle); // Lit la première ligne
        if (strpos($firstLine, '//') !== 0) { // Vérifie si la première ligne n'est pas un commentaire
            rewind($handle); // Revient au début du fichier
        }
        
        $headers = fgetcsv($handle); // Lit les en-têtes du CSV
        
        while (($data = fgetcsv($handle)) !== FALSE) { // Parcourt toutes les lignes de données
            if (count($headers) === count($data)) { // Vérifie que le nombre de colonnes correspond aux en-têtes
                $rows[] = array_combine($headers, $data); // Associe les en-têtes avec les données
            }
        }
        fclose($handle); // Ferme le fichier
    }
    error_log('CSV Data read: ' . print_r($rows, true)); // Enregistre les données lues dans le journal
    return $rows; // Retourne le tableau des données
}

function writeCSV($filename, $data) { // Fonction pour écrire un tableau associatif dans un fichier CSV
    if (empty($data)) { // Vérifie si les données sont vides
        return false;
    }
    
    $fp = fopen($filename, 'w'); // Ouvre le fichier en écriture (écrase le contenu)
    
    // Écrire les en-têtes en utilisant les clés du premier élément
    $headers = array_keys($data[0]); // Récupère les clés du premier élément comme en-têtes
    fputcsv($fp, $headers); // Écrit la ligne d'en-têtes
    
    // Écrire les données
    foreach ($data as $row) { // Parcourt toutes les lignes de données
        fputcsv($fp, $row); // Écrit chaque ligne dans le fichier CSV
    }
    fclose($fp); // Ferme le fichier
    
    return true; // Retourne vrai pour indiquer le succès
}

function checkAuth() { // Fonction pour vérifier si l'utilisateur est authentifié
    session_start(); // Démarre la session
    if (!isset($_SESSION['user_id'])) { // Vérifie si l'ID utilisateur existe en session
        header('Location: /Click-Journey-adem/html/connexion.php'); // Redirige vers la page de connexion
        exit(); // Arrête l'exécution du script
    }
}

function isAdmin() { // Fonction pour vérifier si l'utilisateur est administrateur
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'; // Vérifie le rôle de l'utilisateur
}
?>

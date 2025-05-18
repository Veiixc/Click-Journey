<?php
session_start(); // Démarre la session pour accéder aux données utilisateur
if (!isset($_SESSION['user_id'])) { // Vérifie si l'utilisateur est connecté
    header('Location: ../../html/connexion.php'); // Redirige vers la page de connexion
    exit();
}

function   validateField($field,   $value) { // Fonction pour valider les différents champs du profil
    switch  (  $field  ) {
        case   'email': // Validation de l'email
            if (!filter_var($value,   FILTER_VALIDATE_EMAIL)) { // Vérifie le format de l'email
                return   "L'adresse email n'est pas valide";
            }
            break;
        case   'login': // Validation du login
            if (strlen($value) < 3   || !preg_match('/^[a-zA-Z0-9_]+$/',   $value)) { // Vérifie la longueur et les caractères autorisés
                return   "Le login doit contenir au moins 3 caractères et ne peut contenir que des lettres, chiffres et underscore";
            }
            break;
        case   'nom': // Validation du nom
            if (strlen($value) < 2   || !preg_match('/^[a-zA-Z\s\'-]+$/',   $value)) { // Vérifie la longueur et les caractères autorisés
                return   "Le nom doit contenir au moins 2 caractères et ne peut contenir que des lettres";
            }
            break;
        case   'prenom': // Validation du prénom
            if (strlen($value) < 2   || !preg_match('/^[a-zA-Z\s\'-]+$/',   $value)) { // Vérifie la longueur et les caractères autorisés
                return   "Le prénom doit contenir au moins 2 caractères et ne peut contenir que des lettres";
            }
            break;
        case   'password': // Validation du mot de passe
            if (strlen($value) < 8) { // Vérifie la longueur minimale
                return   "Le mot de passe doit contenir au moins 8 caractères. Veuillez choisir un mot de passe plus fort.";
            }
            
            $strength = 0; // Calcul de la force du mot de passe
            
            if (preg_match('/[a-z]/', $value)) { // S'il contient des minuscules
                $strength++;
            }
            
            if (preg_match('/[A-Z]/', $value)) { // S'il contient des majuscules
                $strength++;
            }
            
            if (preg_match('/[0-9]/', $value)) { // S'il contient des chiffres
                $strength++;
            }
            
            if (preg_match('/[^a-zA-Z0-9]/', $value)) { // S'il contient des caractères spéciaux
                $strength++;
            }
            
            if ($strength < 3) { // Si le mot de passe n'est pas assez fort
                return "Votre mot de passe est trop faible. Veuillez inclure au moins 3 des éléments suivants : lettres minuscules, lettres majuscules, chiffres et caractères spéciaux.";
            }
            break;
        case   'date_naissance': // Validation de la date de naissance
            $date = date_create_from_format('Y-m-d',   $value); // Crée un objet date
            if (!$date   || $date > new DateTime()) { // Vérifie si la date est valide et pas dans le futur
                return   "La date de naissance n'est pas valide";
            }
            break;
        case   'telephone': // Validation du numéro de téléphone
            if (!preg_match("/^[0-9]{10}$/",   $value)) { // Vérifie si c'est exactement 10 chiffres
                return   "Le numéro de téléphone doit contenir exactement 10 chiffres";
            }
            break;
    }
    return   null; // Retourne null si pas d'erreur
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Vérifie si la requête est de type POST
    $isAjaxRequest = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                     strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'; // Détecte si c'est une requête AJAX
    
    $response = [ // Initialise la réponse
        'success' => false,
        'message' => ''
    ];
    
    if (isset($_POST['multi_update']) && $_POST['multi_update'] == '1') { // Si c'est une mise à jour multiple
        $fields = $_POST['fields']; // Récupère tous les champs à mettre à jour
        $hasError = false; // Initialise le drapeau d'erreur
        $errorMessage = "";
        
        foreach ($fields as $field => $value) { // Parcourt tous les champs
            $value = trim($value); // Nettoie la valeur
            
            if (empty($value)) { // Vérifie si la valeur est vide
                $errorMessage = "La valeur ne peut pas être vide";
                $hasError = true;
                break;
            }
            
            $validationError = validateField($field, $value); // Valide le champ
            if ($validationError) { // Si erreur de validation
                $errorMessage = $validationError;
                $hasError = true;
                break;
            }
        }
        
        if ($hasError) { // Si une erreur a été trouvée
            $response['message'] = $errorMessage; // Définit le message d'erreur
            
            if ($isAjaxRequest) { // Si c'est une requête AJAX
                header('Content-Type: application/json'); // Définit l'en-tête comme JSON
                echo json_encode($response); // Retourne la réponse en JSON
                exit();
            } else { // Si c'est une requête standard
                $_SESSION['error'] = $response['message']; // Stocke l'erreur en session
                header('Location: ../../html/profil.php'); // Redirige vers la page de profil
                exit();
            }
        }
    } else { // Si c'est une mise à jour d'un seul champ
        $field = $_POST['field']; // Récupère le nom du champ
        $value = trim($_POST['value']); // Récupère et nettoie la valeur
        
        if (empty($value)) { // Vérifie si la valeur est vide
            $response['message'] = "La valeur ne peut pas être vide";
            
            if ($isAjaxRequest) { // Si c'est une requête AJAX
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            } else { // Si c'est une requête standard
                $_SESSION['error'] = $response['message'];
                header('Location: ../../html/profil.php');
                exit();
            }
        }
        
        $validationError = validateField($field, $value); // Valide le champ
        if ($validationError) { // Si erreur de validation
            $response['message'] = $validationError;
            
            if ($isAjaxRequest) { // Si c'est une requête AJAX
                header('Content-Type: application/json');
                echo json_encode($response);
                exit();
            } else { // Si c'est une requête standard
                $_SESSION['error'] = $response['message'];
                header('Location: ../../html/profil.php');
                exit();
            }
        }
    }

    $users_file = __DIR__ . '/../data/users.csv'; // Chemin vers le fichier des utilisateurs
    $temp_file = __DIR__ . '/../data/users_temp.csv'; // Chemin vers un fichier temporaire
    
    // S'assurer que le dossier data existe
    $data_dir = dirname($users_file); // Récupère le dossier parent
    if (!file_exists($data_dir)) { // Vérifie si le dossier existe
        mkdir($data_dir, 0777, true); // Crée le dossier si nécessaire
    }
    
    // S'assurer que le fichier users.csv existe et a les bonnes permissions
    if (file_exists($users_file)) { // Vérifie si le fichier existe
        chmod($users_file, 0666); // Donne les permissions d'écriture
    }
    
    if (($handle = fopen($users_file, "r")) !== FALSE) {
        $temp = fopen($temp_file, "w");
        
        $header = fgetcsv($handle);
        fputcsv($temp, $header);
        
        rewind($handle);
        $existingLogins = [];
        $existingEmails = [];
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($data[0] !== $_SESSION['user_id']) {
                $existingLogins[] = $data[0];
                $existingEmails[] = $data[6];
            }
        }
        
        if (isset($_POST['multi_update']) && $_POST['multi_update'] == '1') {
            if (isset($fields['login']) && in_array($fields['login'], $existingLogins)) {
                $response['message'] = "Ce login est déjà utilisé";
                
                if ($isAjaxRequest) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    fclose($handle);
                    fclose($temp);
                    unlink($temp_file);
                    exit();
                } else {
                    $_SESSION['error'] = $response['message'];
                    fclose($handle);
                    fclose($temp);
                    unlink($temp_file);
                    header('Location: ../../html/profil.php');
                    exit();
                }
            }
            if (isset($fields['email']) && in_array($fields['email'], $existingEmails)) {
                $response['message'] = "Cette adresse email est déjà utilisée";
                
                if ($isAjaxRequest) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    fclose($handle);
                    fclose($temp);
                    unlink($temp_file);
                    exit();
                } else {
                    $_SESSION['error'] = $response['message'];
                    fclose($handle);
                    fclose($temp);
                    unlink($temp_file);
                    header('Location: ../../html/profil.php');
                    exit();
                }
            }
        } else {
            if ($field === 'login' && in_array($value, $existingLogins)) {
                $response['message'] = "Ce login est déjà utilisé";
                
                if ($isAjaxRequest) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    fclose($handle);
                    fclose($temp);
                    unlink($temp_file);
                    exit();
                } else {
                    $_SESSION['error'] = $response['message'];
                    fclose($handle);
                    fclose($temp);
                    unlink($temp_file);
                    header('Location: ../../html/profil.php');
                    exit();
                }
            }
            if ($field === 'email' && in_array($value, $existingEmails)) {
                $response['message'] = "Cette adresse email est déjà utilisée";
                
                if ($isAjaxRequest) {
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    fclose($handle);
                    fclose($temp);
                    unlink($temp_file);
                    exit();
                } else {
                    $_SESSION['error'] = $response['message'];
                    fclose($handle);
                    fclose($temp);
                    unlink($temp_file);
                    header('Location: ../../html/profil.php');
                    exit();
                }
            }
        }
        
        rewind($handle);
        fgetcsv($handle);
        
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($data[0] === $_SESSION['user_id']) {
                if (isset($_POST['multi_update']) && $_POST['multi_update'] == '1') {
                    foreach ($fields as $fieldName => $fieldValue) {
                        switch($fieldName) {
                            case 'login':
                                $data[0] = $fieldValue;
                                $_SESSION['user_id'] = $fieldValue;
                                break;
                            case 'password':
                                $data[1] = $fieldValue;
                                break;
                            case 'role':
                                $data[2] = $data[2];
                                break;
                            case 'nom':
                                $data[3] = $fieldValue;
                                $_SESSION['nom'] = $fieldValue;
                                break;
                            case 'prenom':
                                $data[4] = $fieldValue;
                                $_SESSION['prenom'] = $fieldValue;
                                break;
                            case 'date_naissance':
                                $data[5] = $fieldValue;
                                $_SESSION['date_naissance'] = $fieldValue;
                                break;
                            case 'email':
                                $data[6] = $fieldValue;
                                $_SESSION['email'] = $fieldValue;
                                break;
                            case 'telephone':
                                $data[7] = $fieldValue;
                                $_SESSION['telephone'] = $fieldValue;
                                break;
                        }
                    }
                } else {
                    switch($field) {
                        case 'login':
                            $data[0] = $value;
                            $_SESSION['user_id'] = $value;
                            break;
                        case 'password':
                            $data[1] = $value;
                            break;
                        case 'role':
                            $data[2] = $data[2];
                            break;
                        case 'nom':
                            $data[3] = $value;
                            $_SESSION['nom'] = $value;
                            break;
                        case 'prenom':
                            $data[4] = $value;
                            $_SESSION['prenom'] = $value;
                            break;
                        case 'date_naissance':
                            $data[5] = $value;
                            $_SESSION['date_naissance'] = $value;
                            break;
                        case 'email':
                            $data[6] = $value;
                            $_SESSION['email'] = $value;
                            break;
                        case 'telephone':
                            $data[7] = $value;
                            $_SESSION['telephone'] = $value;
                            break;
                    }
                }
            }

            fputcsv($temp, $data);
        }
        
        fclose($handle);
        fclose($temp);
        
        // Au lieu d'utiliser unlink puis rename, qui peut poser des problèmes sur Windows
        // On va utiliser copy puis unlink
        if (copy($temp_file, $users_file)) {
            unlink($temp_file);
        } else {
            // Si copy échoue, on essaie la méthode traditionnelle
            @unlink($users_file);
            rename($temp_file, $users_file);
        }
        
        // Déboggage permissions
        $permissions_debug = array(
            'users_file_exists' => file_exists($users_file),
            'users_file_writable' => is_writable($users_file),
            'temp_file_exists' => file_exists($temp_file),
            'data_dir_writable' => is_writable(dirname($users_file))
        );
        
        $response['success'] = true;
        $response['message'] = "Modification effectuée avec succès";
        
        if ($isAjaxRequest) {
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        } else {
            $_SESSION['success'] = $response['message'];
            header('Location: ../../html/profil.php');
            exit();
        }
    }
    
    $response['message'] = "Erreur lors de la modification";
    
    if ($isAjaxRequest) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        $_SESSION['error'] = $response['message'];
        header('Location: ../../html/profil.php');
        exit();
    }
}
?>

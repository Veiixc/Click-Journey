<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../html/connexion.php');
    exit();
}

function   validateField($field,   $value) {
    switch  (  $field  ) {
        case   'email':
            if (!filter_var($value,   FILTER_VALIDATE_EMAIL)) {
                return   "L'adresse email n'est pas valide";
            }
            break;
        case   'login':
            if (strlen($value) < 3   || !preg_match('/^[a-zA-Z0-9_]+$/',   $value)) {
                return   "Le login doit contenir au moins 3 caractères et ne peut contenir que des lettres, chiffres et underscore";
            }
            break;
        case   'nom':
            if (strlen($value) < 2   || !preg_match('/^[a-zA-Z\s\'-]+$/',   $value)) {
                return   "Le nom doit contenir au moins 2 caractères et ne peut contenir que des lettres";
            }
            break;
        case   'prenom':
            if (strlen($value) < 2   || !preg_match('/^[a-zA-Z\s\'-]+$/',   $value)) {
                return   "Le prénom doit contenir au moins 2 caractères et ne peut contenir que des lettres";
            }
            break;
        case   'password':
            if (strlen($value) < 8) {
                return   "Le mot de passe doit contenir au moins 8 caractères. Veuillez choisir un mot de passe plus fort.";
            }
            
            $strength = 0;
            
            if (preg_match('/[a-z]/', $value)) {
                $strength++;
            }
            
            if (preg_match('/[A-Z]/', $value)) {
                $strength++;
            }
            
            if (preg_match('/[0-9]/', $value)) {
                $strength++;
            }
            
            if (preg_match('/[^a-zA-Z0-9]/', $value)) {
                $strength++;
            }
            
            if ($strength < 3) {
                return "Votre mot de passe est trop faible. Veuillez inclure au moins 3 des éléments suivants : lettres minuscules, lettres majuscules, chiffres et caractères spéciaux.";
            }
            break;
        case   'date_naissance':
            $date = date_create_from_format('Y-m-d',   $value);
            if (!$date   || $date > new DateTime()) {
                return   "La date de naissance n'est pas valide";
            }
            break;
        case   'telephone':
            if (!preg_match("/^[0-9]{10}$/",   $value)) {
                return   "Le numéro de téléphone doit contenir exactement 10 chiffres";
            }
            break;
    }
    return   null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isAjaxRequest = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                     strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    $response = [
        'success' => false,
        'message' => ''
    ];
    
    if (isset($_POST['multi_update']) && $_POST['multi_update'] == '1') {
        $fields = $_POST['fields'];
        $hasError = false;
        $errorMessage = "";
        
        foreach ($fields as $field => $value) {
            $value = trim($value);
            
            if (empty($value)) {
                $errorMessage = "La valeur ne peut pas être vide";
                $hasError = true;
                break;
            }
            
            $validationError = validateField($field, $value);
            if ($validationError) {
                $errorMessage = $validationError;
                $hasError = true;
                break;
            }
        }
        
        if ($hasError) {
            $response['message'] = $errorMessage;
            
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
    } else {
        $field = $_POST['field'];
        $value = trim($_POST['value']);
        
        if (empty($value)) {
            $response['message'] = "La valeur ne peut pas être vide";
            
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
        
        $validationError = validateField($field, $value);
        if ($validationError) {
            $response['message'] = $validationError;
            
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
    }

    $users_file = __DIR__ . '/../data/users.csv';
    $temp_file = __DIR__ . '/../data/users_temp.csv';
    
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
                            case 'nom':
                                $data[3] = $fieldValue;
                                $_SESSION['nom'] = $fieldValue;
                                break;
                            case 'prenom':
                                $data[4] = $fieldValue;
                                $_SESSION['prenom'] = $fieldValue;
                                break;
                            case 'email':
                                $data[6] = $fieldValue;
                                $_SESSION['email'] = $fieldValue;
                                break;
                            case 'date_naissance':
                                $data[5] = $fieldValue;
                                $_SESSION['date_naissance'] = $fieldValue;
                                break;
                            case 'telephone':
                                $data[7] = $fieldValue;
                                $_SESSION['telephone'] = $fieldValue;
                                break;
                            case   'password':
                                $data[1]   =   $fieldValue;
                                break;
                        }
                    }
                } else {
                    switch($field) {
                        case 'login':
                            $data[0] = $value;
                            $_SESSION['user_id'] = $value;
                            break;
                        case 'nom':
                            $data[3] = $value;
                            $_SESSION['nom'] = $value;
                            break;
                        case 'prenom':
                            $data[4] = $value;
                            $_SESSION['prenom'] = $value;
                            break;
                        case 'email':
                            $data[6] = $value;
                            $_SESSION['email'] = $value;
                            break;
                        case 'date_naissance':
                            $data[5] = $value;
                            $_SESSION['date_naissance'] = $value;
                            break;
                        case 'telephone':
                            $data[7] = $value;
                            $_SESSION['telephone'] = $value;
                            break;
                        case   'password':
                            $data[1]   =   $value;
                            break;
                    }
                }
            }

            fputcsv($temp, $data);
        }
        
        fclose($handle);
        fclose($temp);
        
        unlink($users_file);
        rename($temp_file, $users_file);
        
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

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../html/connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $field = $_POST['field'];
    $value = trim($_POST['value']);
    




    if (empty($value)) {


        $_SESSION['error'] = "La valeur ne peut pas être vide !!!";

        header('Location: ../../html/profil.php');
        exit();
    }

   
    if ($field === 'telephone' && !preg_match("/^[0-9]{10}$/", $value)) {


        $_SESSION['error'] = "Le numéro de téléphone doit contenir exactement 10 chiffres";


        header('Location: ../../html/profil.php');
        exit();
    }

    $users_file = __DIR__ . '/../data/users.csv';
    $temp_file = __DIR__ . '/../data/users_temp.csv';
    
    if (($handle = fopen($users_file, "r")) !== FALSE) {
        $temp = fopen($temp_file, "w");
        
     
        $header = fgetcsv($handle);
        fputcsv($temp, $header);



        
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($data[0] === $_SESSION['user_id']) {
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
                }
            }


            fputcsv($temp, $data);
        }
        
        fclose($handle);


        fclose($temp);
        
        unlink($users_file);


        rename($temp_file, $users_file);


        
        
    $_SESSION['success'] = "Modification effectuée avec succès";
    }
    
    header('Location: ../../html/profil.php');
    exit();
}
?>

<?php
session_start();
session_unset(); // Efface toutes les variables de session
session_destroy(); // Détruit la session
session_write_close(); // S'assure que la session est bien fermée
header('Location: /fin2/html/page-acceuil.php');
exit();
?>

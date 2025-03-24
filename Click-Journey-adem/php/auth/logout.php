<?php
session_start();









$_SESSION['info'] = 'Vous avez été déconnecté avec succès !!!';
session_unset();



session_destroy();


session_write_close();

setcookie(session_name(),'',0,'/');


session_regenerate_id(true);



header('Location: /Click-Journey-adem/html/page-acceuil.php');
exit();
?>

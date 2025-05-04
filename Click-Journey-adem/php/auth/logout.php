<?php
session_start();

if (isset($_SESSION['cart']) && !empty($_SESSION['cart']))   {
    $cookie_lifetime   = 60 * 60 *     24 * 30;
    $cart_json   = json_encode($_SESSION['cart']);
    setcookie(   'saved_cart',      $cart_json, time() + $cookie_lifetime, '/'   );
}

$_SESSION['info']     = 'Vous avez été déconnecté avec succès !!!';
session_unset(  );

session_destroy(


);

session_write_close();

setcookie(   session_name(),   '',   0,   '/'   );

session_regenerate_id(   true   );

header(  'Location: /Click-Journey-adem/html/page-acceuil.php'  );
exit(  );
?>

<?php
session_start(); // Démarre la session pour pouvoir la détruire ensuite

if (isset($_SESSION['cart']) && !empty($_SESSION['cart']))   { // Vérifie si un panier existe en session
    $cookie_lifetime   = 60 * 60 *     24 * 30; // Définit la durée de vie du cookie (30 jours)
    $cart_json   = json_encode($_SESSION['cart']); // Convertit le panier en JSON
    setcookie(   'saved_cart',      $cart_json, time() + $cookie_lifetime, '/'   ); // Sauvegarde le panier dans un cookie
}

$_SESSION['info']     = 'Vous avez été déconnecté avec succès !!!'; // Message de confirmation
session_unset(  ); // Supprime toutes les variables de session

session_destroy( // Détruit complètement la session


);

session_write_close(); // Finalise l'écriture de la session

setcookie(   session_name(),   '',   0,   '/'   ); // Efface le cookie de session

session_regenerate_id(   true   ); // Génère un nouvel ID de session (sécurité)

header(  'Location: /Click-Journey-adem/html/page-acceuil.php'  ); // Redirige vers la page d'accueil
exit(  ); // Arrête l'exécution du script
?>

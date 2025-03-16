<?php
require_once '../php/auth/check_auth.php';
requireLogin();

$circuit_id = isset($_GET['circuit']) ? $_GET['circuit'] : null;
if (!$circuit_id) {
    header('Location: presentation.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Réservation</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>
<body>
    <header>
        // ...existing header code from other pages...
    </header>
    
    <div class="conteneur">
        <div class="formulaire">
            <h2>Réservation du Circuit <?php echo htmlspecialchars($circuit_id); ?></h2>
            <form id="reservation-form" method="post" action="../php/reservations/create.php">
                <input type="hidden" name="circuit_id" value="<?php echo htmlspecialchars($circuit_id); ?>">
                
                <label for="date_depart">Date de départ souhaitée</label>
                <input type="date" id="date_depart" name="date_depart" required>
                
                <label for="nombre_personnes">Nombre de personnes</label>
                <input type="number" id="nombre_personnes" name="nombre_personnes" min="1" max="10" required>
                
                <div class="form-bouton">
                    <button type="submit">Confirmer la réservation</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
</body>
</html>

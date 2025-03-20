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
        <div class="logo-conteneur">
            <a href="page-acceuil.html" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
        <div class="header-links">
            <a href="administrateur.html"><button>Administrateur</button></a>
            <a href="recherche.html"><button>Rechercher</button></a>
            <a href="présentation.html"><button>Notre agence</button></a>
            <a href="profil.html"><button>Profil</button></a>
            <a href="connexion.html"><button>Se connecter / S'inscrire</button></a>
        </div>
    </header>
    
    <div class="conteneur">
        <div class="formulaire reservation-form">
            <h2>Réservation du Circuit <?php echo htmlspecialchars($circuit_id); ?></h2>
            <form id="reservation-form" method="post" action="../php/reservations/create.php">
                <input type="hidden" name="circuit_id" value="<?php echo htmlspecialchars($circuit_id); ?>">
                
                <div class="form-group">
                    <label for="date_depart">Date de départ souhaitée</label>
                    <input type="date" id="date_depart" name="date_depart" required min="<?php echo date('Y-m-d'); ?>">
                </div>
                

                
                <div class="form-group">
                    <label for="nombre_personnes">Nombre de personnes</label>
                    <input type="number" id="nombre_personnes" name="nombre_personnes" min="1" max="10" value="1" required>
                </div>
                
                <div class="form-group">
                    <label for="commentaires">Commentaires ou demandes spéciales</label>
                    <textarea id="commentaires" name="commentaires" rows="4"></textarea>
                </div>
                
                <div class="form-buttons">
                    <a href="javascript:history.back()" class="btn-secondaire">Retour</a>
                    <button type="submit" class="btn-principal">Confirmer la réservation</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
</body>
</html>

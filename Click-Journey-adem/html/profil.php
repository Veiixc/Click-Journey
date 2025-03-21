<?php
require_once '../php/auth/check_auth.php';
require_once '../php/profile/get_reservations.php';
requireLogin();

$reservations = getUserReservations($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Mon profil</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>

<body>
    <header>
        <div class="logo-conteneur">
            <a href="page-acceuil.php" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>
        </div>
        
<div class="header-links">
    <a href="administrateur.php"><button>Administrateur</button></a>
    <a href="recherche.php"><button>Rechercher</button></a>
    <a href="présentation.php"><button>Notre agence</button></a>
    <a href="profil.php"><button>Profil</button></a>
    <a href="../php/auth/logout.php"><button>Déconnexion</button></a>
</div>


    </header>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px; border-radius: 5px; text-align: center;">
            <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']); // Important: On supprime le message après l'avoir affiché
            ?>
        </div>
    <?php endif; ?>

    <div class="conteneur">
        <div class="conteneur-profil">
            <h2>Mon Profil</h2>
            <div class="section-photo-profil">
                <div class="photo-profil">
                    <img id="imageProfil" src="../img/profil.svg" alt="Photo de profil">
                    <input type="file" id="televerserImage" accept="image/*" style="display: none"><br>
                    <button class="bouton-changer-photo" onclick="document.getElementById('televerserImage').click()">
                        <i></i> Changer la photo
                    </button>
                </div>
            </div>
            <div class="section-profil">
                <div class="champ-profil">
                    <span class="etiquette">Nom complet : </span>
                    <span id="nom" class="valeur"><?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?></span>
                    <button class="btn-editer">
                        <i></i>✏️
                    </button>
                </div>
                <div class="champ-profil">
                    <span class="etiquette">Email : </span>
                    <span id="courriel" class="valeur"><?php echo $_SESSION['email']; ?></span>
                    <button class="btn-editer">
                        <i></i>✏️
                    </button>
                </div>
                <div class="champ-profil">
                    <span class="etiquette">Date de naissance : </span>
                    <span id="dateNaissance" class="valeur"><?php echo $_SESSION['date_naissance']; ?></span>
                    <button class="btn-editer">
                        <i></i>✏️
                    </button>
                </div>
                <div class="champ-profil">
                    <span class="etiquette">Téléphone : </span>
                    <span id="telephone" class="valeur">+33 6 12 34 56 78</span>
                    <button class="btn-editer">
                        <i></i>✏️
                    </button>
                </div>
                
                <!-- Ajout de la section des voyages réservés -->
                <div class="reservations-section">
                    <h3>Mes Voyages Réservés</h3>
                    <div class="reservations-grid">
                        <?php if (empty($reservations)): ?>
                            <p>Aucun voyage réservé pour le moment.</p>
                        <?php else: ?>
                            <?php foreach($reservations as $reservation): ?>
                                <a href="circuits/circuit<?php echo htmlspecialchars($reservation['circuit_id']); ?>.php" class="reservation-card">
                                    <div class="reservation-header">
                                        <h4>Circuit <?php echo htmlspecialchars($reservation['circuit_id']); ?></h4>
                                        <span class="reservation-date">Réservé le <?php echo htmlspecialchars($reservation['date_reservation']); ?></span>
                                    </div>
                                    <div class="reservation-details">
                                        <?php foreach($reservation['stages'] as $stage): ?>
                                            <p><strong><?php echo htmlspecialchars($stage['title']); ?></strong></p>
                                            <ul>
                                                <li>Hébergement: <?php echo htmlspecialchars($stage['lodging']); ?></li>
                                                <li>Repas: <?php echo htmlspecialchars($stage['meals']); ?></li>
                                            </ul>
                                        <?php endforeach; ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="partage-social">
                    <h3>Partager mon profil</h3>
                    <div class="boutons-sociaux">
                        <button class="btn-partage facebook">
                            <i></i> Facebook
                        </button>
                        <button class="btn-partage twitter">
                            <i></i> Twitter
                        </button>
                        <button class="btn-partage linkedin">
                            <i></i> LinkedIn
                        </button>
                        <button class="btn-partage whatsapp">
                            <i></i> WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

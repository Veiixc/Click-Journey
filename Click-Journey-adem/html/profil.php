<?php
require_once '../php/auth/check_auth.php';
require_once '../php/profile/get_reservations.php';
requireLogin();

$reservations = getUserReservations($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Mon profil</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
    <script>
    // Fonction pour basculer la visibilité du mot de passe
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('passwordField');
        const toggleBtn = document.getElementById('togglePassword');
        
        if (passwordField.type === 'password') {
            // Si on passe de caché à visible, récupérer le vrai mot de passe
            if (passwordField.value === '••••••••') {
                // Utiliser AJAX pour récupérer le vrai mot de passe
                fetch('../php/profile/get_current_password.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            passwordField.value = data.password;
                            passwordField.type = 'text';
                            toggleBtn.innerHTML = '👁️‍🗨️';
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                    });
            } else {
                passwordField.type = 'text';
                toggleBtn.innerHTML = '👁️‍🗨️';
            }
        } else {
            // On repasse en mode caché
            if (passwordField.classList.contains('not-editing')) {
                passwordField.value = '••••••••';
            }
            passwordField.type = 'password';
            toggleBtn.innerHTML = '👁️';
        }
    }

    // Initialiser le champ de mot de passe
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('passwordField');
        
        if (passwordField) {
            // Marquer le champ comme non éditable au départ
            passwordField.classList.add('not-editing');
            
            // Écouter les changements dans le champ
            passwordField.addEventListener('input', function() {
                // Si l'utilisateur commence à taper, on le considère comme en édition
                if (passwordField.value !== '••••••••') {
                    passwordField.classList.remove('not-editing');
                }
            });
        }
    });
    </script>
    <script src="../js/theme-switcher.js" defer></script>
    <link rel="stylesheet" href="../API/profile-async.css">
    <style>
        .champ-profil {
            margin-bottom: 15px;
            position: relative;
        }
        .input-edition:disabled {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            color: #666;
            cursor: not-allowed;
        }
        .btn-edit, .btn-confirm, .btn-cancel {
            margin-left: 5px;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 16px;
        }
        .btn-save {
            margin-left: 5px;
            cursor: pointer;
            padding: 4px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn-save:hover {
            background-color: #45a049;
        }
        .modified {
            background-color: rgba(255, 255, 0, 0.1);
            border-radius: 5px;
            padding: 5px;
        }
        .btn-submit-all {
            display: block;
            margin: 20px 0;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-submit-all:hover {
            background-color: #45a049;
        }
        
        /* Styles pour le bouton toggle password */
        .form-edition {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;  
            padding-right: 100px;  
        }
        
        .toggle-password {
            position: absolute;
            right: 45px;  /* Ajusté pour laisser de l'espace pour le bouton save */
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            z-index: 10;
            padding: 8px 12px;  /* Padding augmenté */
            background-color: rgba(240, 240, 240, 0.5);
            border-radius: 50%;
            transition: background-color 0.3s;
            margin: 0 5px;  /* Ajoute des marges horizontales */
        }
        
        .char-counter {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            text-align: right;
        }
        
        .validation-message {
            font-size: 12px;
            color: #721c24;
            margin-top: 5px;
        }
        
        .date-form {
            position: relative;
        }
        
        input[type="date"] {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        
        input[type="date"]:invalid {
            border-color: #dc3545;
        }
        
        input[type="date"]:valid {
            border-color: #28a745;
        }
    </style>
    <script src="../js/profile-edit.js" defer></script>
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
            <a href="cart.php"><button>Panier</button></a>
            <a href="profil.php"><button>Profil</button></a>
            <a href="../php/auth/logout.php"><button>Déconnexion</button></a>
        </div>
    </header>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin: 10px; border-radius: 5px; text-align: center;">
            <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']); 
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px; border-radius: 5px; text-align: center;">
            <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']); 
            ?>
        </div>
    <?php endif; ?>

    <div class="conteneur">
        <div class="conteneur-profil">
            <h2>Mon Profil</h2>
            <div class="section-profil">
                <div class="champ-profil">
                    <span class="etiquette">Nom complet : </span>
                    <form class="form-edition ajax-form" action="javascript:void(0);" onsubmit="return false;">
                        <input type="hidden" name="field" value="nom">
                        <input type="text" name="value" value="<?php echo $_SESSION['nom']; ?>" class="input-edition" pattern="[a-zA-Z\s\'-]+" title="Le nom ne peut contenir que des lettres, espaces, apostrophes et tirets" minlength="2" required>
                        <button type="button" class="btn-save">💾</button>
                    </form>
                </div>
                <div class="champ-profil">
                    <span class="etiquette">Email : </span>
                    <form class="form-edition ajax-form" action="javascript:void(0);" onsubmit="return false;">
                        <input type="hidden" name="field" value="email">
                        <input type="email" name="value" value="<?php echo $_SESSION['email']; ?>" class="input-edition" required>
                        <button type="button" class="btn-save">💾</button>
                    </form>
                </div>
                <div class="champ-profil">
                    <span class="etiquette">Date de naissance : </span>
                    <form class="form-edition date-form ajax-form" action="javascript:void(0);" onsubmit="return false;">
                        <input type="hidden" name="field" value="date_naissance">
                        <input type="date" name="value" value="<?php echo $_SESSION['date_naissance']; ?>" class="input-edition" max="<?php echo date('Y-m-d'); ?>" required>
                        <button type="button" class="btn-save">💾</button>
                        <div class="validation-message"></div>
                    </form>
                </div>
                <div class="champ-profil">
                    <span class="etiquette">Téléphone : </span>
                    <form class="form-edition ajax-form" action="javascript:void(0);" onsubmit="return false;">
                        <input type="hidden" name="field" value="telephone">
                        <input type="tel" name="value" pattern="[0-9]{10}" title="Le numéro doit contenir 10 chiffres" value="<?php echo isset($_SESSION['telephone']) ? $_SESSION['telephone'] : ''; ?>" class="input-edition" required>
                        <button type="button" class="btn-save">💾</button>
                    </form>
                </div>
                <div class="champ-profil">
                    <span class="etiquette">Login : </span>
                    <form class="form-edition ajax-form" action="javascript:void(0);" onsubmit="return false;">
                        <input type="hidden" name="field" value="login">
                        <input type="text" name="value" value="<?php echo $_SESSION['user_id']; ?>" class="input-edition" pattern="[a-zA-Z0-9_]+" title="Le login ne peut contenir que des lettres, chiffres et underscore" minlength="3" required>
                        <button type="button" class="btn-save">💾</button>
                    </form>
                </div>

                <div class="champ-profil">
                   <span class="etiquette">Prénom : </span>
                    <form class="form-edition ajax-form" action="javascript:void(0);" onsubmit="return false;">
                        <input type="hidden" name="field" value="prenom">
                        <input type="text" name="value" value="<?php echo isset($_SESSION['prenom']) ? $_SESSION['prenom'] : ''; ?>" class="input-edition" pattern="[a-zA-Z\s\'-]+" title="Le prénom ne peut contenir que des lettres, espaces, apostrophes et tirets" minlength="2" required>
                         <button type="button" class="btn-save">💾</button>
                    </form>
                </div>
                
                <div class="champ-profil">
                     <span class="etiquette">Mot de passe : </span>
                    <form class="form-edition ajax-form" action="javascript:void(0);" onsubmit="return false;">
                      <input type="hidden" name="field" value="password">
                      <input type="password" name="value" id="passwordField" value="••••••••" class="input-edition not-editing" minlength="8" required>
                      <button type="button" onclick="togglePasswordVisibility()" id="togglePassword" class="toggle-password">👁️</button>
                      <button type="button" class="btn-save">💾</button>
                    </form>
                </div>
                
                <div class="reservations-section">
                    <h3>Mes Voyages Réservés</h3>
                    <div class="reservations-grid">
                        <?php if (empty($reservations)): ?>
                            <p>Aucun voyage réservé pour le moment.</p>
                        <?php else: ?>
                            <?php foreach ($reservations as $reservation): ?>
                                <a href="circuits/circuit<?php echo htmlspecialchars($reservation['circuit_id']); ?>.php" class="reservation-card">
                                    <div class="reservation-header">
                                        <h4>Circuit <?php echo htmlspecialchars($reservation['circuit_id']); ?></h4>
                                        <span class="reservation-date">Réservé le <?php echo htmlspecialchars($reservation['date_reservation']); ?></span>
                                    </div>
                                    <div class="reservation-details">
                                        <?php foreach ($reservation['stages'] as $stage): ?>
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
            </div>
        </div>
    </div>
</body>
</html>

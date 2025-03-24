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



    <link rel="stylesheet" type="text/css" href="../css/journey.css">
    <title>Réservation</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
</head>
<body>
    <header>
        <div class="logo-conteneur">
            <a href="accueil.php" class="logo"><img src="../img/logo.png"></a>
            <span id="test">Time Traveler</span>



    
        </div>
        <div class="header-links">
            <a href="administrateur.php"><button>Administrateur</button></a>
            <a href="recherche.php"><button>Rechercher</button></a>
            <a href="présentation.php"><button>Notre agence</button></a>
            <a href="profil.php"><button>Profil</button></a>


        
            <a href="../php/auth/logout.php"><button>Se déconnecter</button></a>
        </div>
    </header>
    
    <div class="conteneur">
        <div class="formulaire reservation-form">
            <h2>Personnalisation du Circuit <?php echo htmlspecialchars($circuit_id); ?></h2>
            
            <form action="../php/reservations/save_choices.php" method="POST">
                <input type="hidden" name="circuit_id" value="<?php echo htmlspecialchars($circuit_id); ?>">

                <div class="form-group date-selection">
         <div class="option-group">
                        <label for="date_debut">Date de début</label>
                        <input type="date" id="date_debut" name="date_debut" required 
                               min="<?php echo date('Y-m-d'); ?>">
                    </div>           <div class="option-group">
                        <label for="date_fin">Date de fin</label>
                        <input type="date" id="date_fin" name="date_fin" required>
                    </div>
       </div>

        <div class="form-group">
                    <label for="nb_personnes">Nombre de personnes</label>
                    <select id="nb_personnes" name="nb_personnes" required>
                        <?php for($i = 1; $i <= 10; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?> personne<?php echo $i > 1 ? 's' : ''; ?></option>
               <?php endfor; ?>
                    </select>
                </div>

          <div class="journey-stages">
                    <?php include '../php/stages/get_stages.php'; ?>
                    
              <?php foreach ($stages as $index => $stage): ?>
                    <div class="stage-card">
                        <div class="stage-header">
                            <h3 class="stage-title">Étape <?php echo $index + 1; ?>: <?php echo htmlspecialchars($stage['title']); ?></h3>
                            <span class="stage-duration"><?php echo htmlspecialchars($stage['duration']); ?> jours</span>
                        </div>
                    
                        <div class="stage-options">
                         <div class="option-group">
                                <label for="lodging-<?php echo $index; ?>">Hébergement</label>
                                <select id="lodging-<?php echo $index; ?>" name="stages[<?php echo $index; ?>][lodging]" required>
                            <option value="">Choisissez un hébergement</option>
                                    <?php foreach ($stage['lodging_options'] as $option): ?>
                               <option value="<?php echo htmlspecialchars($option['id']); ?>">
                                            <?php echo htmlspecialchars($option['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="option-group">
                                <label for="meals-<?php echo $index; ?>">Restauration</label>



                                <select id="meals-<?php echo $index; ?>" name="stages[<?php echo $index; ?>][meals]">
                                    <option value="none">Sans repas</option>



                                    <option value="breakfast">Petit déjeuner</option>
                                    <option value="half">Demi-pension</option>


                                    <option value="full">Pension complète</option>
                                </select>
                            </div>
                            
                            <div class="option-group">
                               
                            
                            
                <label for="activities-<?php echo $index; ?>">Activités</label>

                                
                                
                                <select id="activities-<?php echo $index; ?>" name="stages[<?php echo $index; ?>][activities]" multiple>
                                    <?php foreach ($stage['activities'] as $activity): ?>
                                        <option value="<?php echo htmlspecialchars($activity['id']); ?>">
              <?php echo htmlspecialchars($activity['name']); ?>
                                        </option>





                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="option-group">
                                <label for="transport-<?php echo $index; ?>">Transport vers prochaine étape</label>
                                <select id="transport-<?php echo $index; ?>" name="stages[<?php echo $index; ?>][transport]">
                                  
                                
                                
                                
                                
                                
                                
                                
                                <?php foreach ($stage['transport_options'] as $transport): ?>
                                        <option value="<?php echo htmlspecialchars($transport['id']); ?>">
                   <?php echo htmlspecialchars($transport['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                     </div>



                        </div>
                    </div>
         <?php endforeach; ?>
                </div>
         
                <button type="submit" class="summary-button">Voir le récapitulatif</button>
    </form>
        </div>
    </div>
    
    <script src="../js/script.js"></script>
</body>
</html>

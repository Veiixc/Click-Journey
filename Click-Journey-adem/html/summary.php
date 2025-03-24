<?php
require_once '../php/auth/check_auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/journey.css">
    <title>Récapitulatif du voyage</title>
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
            <a href="recherche.php"><button>Rechercher


  </button></a>


       <a href="présentation.php"><button>Notre agence</button></a>



        
  <a href="profil.php"><button>Profil</button></a>



            <a href="../php/auth/logout.php"><button>Déconnexion</button></a>
        </div>
    </header>
    
    <div class="conteneur">
        <div class="formulaire reservation-form">
            <h2>Récapitulatif de votre voyage personnalisé</h2>
            
          
            <div class="reservation-details">



                <p><strong>Date de début :</strong> <?php echo date('d/m/Y', strtotime($_SESSION['date_debut'])); ?></p>
    
    
                <p><strong>Date de fin :</strong> <?php echo date('d/m/Y', strtotime($_SESSION['date_fin'])); ?></p>
    
        <p><strong>Nombre de personnes :</strong> <?php echo $_SESSION['nb_personnes']; ?></p>





            </div>


            
            <div class="journey-stages">
                <?php 
                $stages = $_SESSION['journey_stages'] ?? [];
                



                if (empty($stages)) {
                    echo '<p>Aucune étape n\'a été sélectionnée. <a href="presentation.php">Retourner à la sélection</a></p>';
                } else {
                    foreach ($stages as $index => $stage): 
                ?>




                <div class="stage-card">



                    <div class="stage-header">



                        <h3 class="stage-title"><?php echo htmlspecialchars($stage['title']); ?></h3>



        
                    </div>
                    <div class="stage-details">



      <p><strong>Hébergement:</strong> <?php echo htmlspecialchars($stage['lodging']); ?></p>


        <p><strong>Restauration:</strong> <?php echo htmlspecialchars($stage['meals']); ?></p>





<p><strong>Activités:</strong> <?php echo htmlspecialchars(implode(', ', $stage['activities'])); ?></p>





 <p><strong>Transport:</strong> <?php echo htmlspecialchars($stage['transport']); ?></p>
                    </div>
     </div>
                <?php 
                    endforeach;
                }
                ?>
            </div>
      
            <div class="form-buttons">
                <a href="reservation.php?circuit=<?php echo $_SESSION['circuit_id']; ?>" class="summary-button secondary">Modifier la personnalisation</a>
      <form action="../php/reservations/confirm.php" method="POST">
                    <button type="submit" class="summary-button">Confirmer la réservation</button>
      </form>
            </div>
    
    
    </div>
    </div>
</body>
</html>

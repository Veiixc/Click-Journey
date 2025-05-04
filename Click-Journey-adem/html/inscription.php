<?php 

  require_once      '../php/auth/check_auth.php';

    redirectIfLoggedIn(      );

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Inscription</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
    <script src="../js/formValidation.js" defer></script>
    <script src="../js/theme-switcher.js" defer></script>
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
            <a href="connexion.php"><button>Se connecter / S'inscrire</button></a>
        </div>
    </header>
    <div class="conteneur">
        <div id="formulaire-inscription" class="formulaire">
            <h2>Inscription</h2>
            <form method="post"    action="../php/auth/register.php">
                <?php 
                
               if(   isset($_SESSION['error'])          ):   
                 
                ?>
                    <div style="color: red;">
                     
                        <?php 
                          echo      $_SESSION['error']; 
                            
                        unset(
                              $_SESSION['error']
                           ); 
                        ?>
                      
                    </div>
                <?php 
                
             endif      ; 
                
                ?>
                <div class="form-group">
                 <label for="login">Login</label>
                      <input type="text" id="login" name="login" maxlength="50" required>
                </div>
                
                  <div class="form-group">
                    <label for="password">Mot de passe</label>
                   <input type="password" id="password" name="password" maxlength="50" required>
                </div>
                
            <div class="form-group">
                      <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" maxlength="100" required>
                </div>
                
                <div class="form-group">
              <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" maxlength="100" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" maxlength="100" required>
                </div>
                
                <div class="form-group">
                    <label for="telephone">Numéro de téléphone</label>
                    <input type="tel" id="telephone" name="telephone" pattern="[0-9]{10}" title="Veuillez entrer un numéro de téléphone valide à 10 chiffres" required>
                </div>
                
                <div   class="form-group"  >
                   <label  for="date_naissance">Date de naissance</label>
                    <input   type="date"  id="date_naissance" name="date_naissance"  required>
                </div>
                
                <div  class="form-bouton" >
                    <button   type="submit"  >S'inscrire</button>
                 </div>
            </form>
            <p>Déjà un compte ? <a href="connexion.php">Se connecter</a></p>
        </div>
    </div>
</body>
</html>
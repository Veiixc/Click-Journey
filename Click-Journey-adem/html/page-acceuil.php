<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Acceuil</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
    <script src="../js/theme-switcher.js" defer></script>
    <script src="../js/cart-persistence.js" defer></script>
</head>

<body>
    <header class="acceuil">
        <div class="logo-conteneur">
            <a href="page-acceuil.php" class="logo"><img src="../img/logo.png"></a>
            <a href="présentation.php" class="effet-titre police-2em">Time Traveler</a>
        </div>

        <div class="header-links">
            <a href="cart.php"><button>Panier</button></a>
            <a href="connexion.php" class="effet-titre police-2em">Se connecter / S'inscrire</a>
        </div>
    </header>

    <?php


    session_start();


    if(isset($_SESSION['info'])): 
    
    
    ?>
        <div style="background-color: #cce5ff; color: #004085; padding: 10px; margin: 10px; border-radius: 5px; text-align: center;">


            <?php 



                echo 
                
                    $_SESSION['info'];
                
                
                unset(
                    
                    $_SESSION['info']
                    
                    );
                    
                    
            ?>
            
            
        </div>
        
        
    <?php 
    
    
    endif; 
    
    
    ?>

    <div class="diaporama-fond">
        <div class="diaporama-container">
            <div class="diapositive">  <img 
            src="../img/maya.jpg" 
            alt="Image 1" 
            loading="eager">  </div>



     <div    class="diapositive">   <img 
                 src="../img/rome.jpg" 
                 alt="Image 2" 
                 loading="eager">   </div>
            <div class="diapositive"><img 
            
            src="../img/Tah-majal.jpg" 
            
            alt="Image 3" 
            
            loading="eager"></div>
            <div class="diapositive">    <img src="../img/gêne.jpg" alt="Image 4" loading="eager">     </div>
       <div class="diapositive">     <img 
       
       src="../img/maya.jpg" 
       
       alt="Image 1" 
       
       loading="eager">    </div>
        </div>
    </div>
    <main>


    
        <div class="titre">


            <a href="présentation.php" 
            
            class="effet-titre police-3em">Découvre le monde ancien</a><br>
    <a 
    
    href="présentation.php" 
    
    class="effet-titre police-3em">Et pars sur les traces des civilisations
                anciennes</a>
   </div>
    </main>
    <footer>
        <a href="https://twitter.com">   <img src="../img/twitter.jpg">   </a>
        <a href="https://instagram.com">     <img src="../img/insta.jpg">     </a>
        <a href="https://linkedin.com">  <img src="../img/linkedin.jpg">  </a>
    </footer>
</body>


</html>

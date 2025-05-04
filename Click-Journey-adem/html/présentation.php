<?php
require_once '../php/auth/check_auth.php';
require_once '../php/cart/cart_functions.php';


$circuits = [



    
    ['id' => 1, 'titre' => 'Kyoto', 'duree' => 15, 'prix' => 4789, 'description' => 'Le voyage débute à Kyoto...'],
    ['id' => 2, 'titre' => 'Le Caire', 'duree' => 20, 'prix' => 5989, 'description' => 'Le voyage débute au Caire...'],
    ['id' => 3, 'titre' => 'Gênes', 'duree' => 11, 'prix' => 2289, 'description' => 'Bienvenue à Gênes...'],




    ['id' => 4, 'titre' => 'Angleterre', 'duree' => 8, 'prix' => 1800,         'description' => 'Votre voyage commencez à Bath...'],
    ['id' => 5, 'titre' => 'Sites Mayas', 'duree' => 13, 'prix' => 3999, 'description' => 'Découvrez les sites mayas...'],



    ['id' => 6, 'titre' => 'Les Alpes', 'duree' => 10, 'prix' => 2999, 'description' => 'Explorez les Alpes...'],


    ['id' => 7,     'titre' => 'Tibet', 'duree' => 16, 'prix' => 4299, 'description' => 'Découvrez les monastères du toit du monde...'],


    ['id' => 8,     'titre' => 'Angkor', 'duree' => 12, 'prix' => 3499, 'description' => 'Explorez les temples d\'Angkor...'],


    ['id' => 9,     'titre' => 'Australie', 'duree' => 14, 'prix' => 4599, 'description' => 'Découvrez les merveilles de l\'Australie...'],
    ['id' => 10, 'titre' => 'Loire', 'duree' => 7, 'prix' => 1999, 'description' => 'Visitez les châteaux de la Loire...'],


    ['id' => 11,    'titre' => 'Andalousie', 'duree' => 9, 'prix' => 2599, 'description' => 'Partez à la découverte de l\'Andalousie...'],



    ['id' => 12, 'titre' => 'Norvège', 'duree' => 16, 'prix' => 4999, 'description' => 'Explorez les fjords de Norvège avec nous !'],


    ['id' => 13,             'titre' => 'Amérique du Sud', 'duree' => 18, 'prix' => 5499, 'description' =>              'Découvrez les merveilles de l\'Amérique du Sud !!!'],
    ['id' => 14,                   'titre' => 'Antarctique', 'duree' => 21, 'prix' => 5999,        'description' => 'Partez à l\'aventure en Antarctique...'],



    ['id' => 15, 'titre' =>                  'Transsibérien', 'duree' => 18, 'prix' => 4899, 'description' =>                 'Le Transsibérien de Moscou à Vladivostok...'],











    ['id' => 16, 'titre' =>                'Mongolie', 'duree' => 14,                  'prix' => 3999, 'description' => 'Les steppes mongoles et la vie nomade...'],



    ['id' => 17, 'titre' =>                'Himalaya', 'duree' => 15,             'prix' => 3799,                  'description' => 'Trek dans l\'Himalaya et découverte des temples...']
];


$indices = array_rand($circuits, 2);



$circuits_aleatoires =             [$circuits[$indices[0]], $circuits[$indices[1]]];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">




    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Notre agence</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
    <script src="../js/theme-switcher.js" defer></script>
    <script src="../js/notifications.js" defer></script>
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
            <a href="cart.php" class="cart-badge"><button>Panier</button>
                <?php if(isLoggedIn() && getCartItemCount() > 0): ?>
                    <span class="cart-count"><?php echo getCartItemCount(); ?></span>
                <?php endif; ?>
            </a>
   <a href="profil.php"><button>Profil</button></a>








            <?php if(isLoggedIn()): ?>
                <a href="../php/auth/logout.php"><button>Déconnexion</button></a>
            <?php else: ?>
                <a href="connexion.php"><button>Se connecter / S'inscrire</button></a>






            <?php endif; ?>
        </div>
    </header>





    <div class="conteneur">
        <h1>Voyages Recommandés</h1>
        <div class="circuits-conteneur">
            <div class="circuit">



                <h2>Les plus récents</h2>



                <div class="circuit-item">
                    <h3>Circuit 16 - Mongolie</h3>
                    <p>14 jours - 3999€</p>
                    <p>Les steppes mongoles et la vie nomade...</p>
                    <div class="circuit-actions">
                        <a href="../php/cart/add_to_cart.php?circuit_id=16" class="add-to-cart-btn">Ajouter au panier</a>
                        <a href="circuits/circuit16.php" class="details-btn">Voir détails</a>
                    </div>
                </div>
                <div class="circuit-item">
                    <h3>Circuit 17 - Himalaya</h3>
                    <p>15 jours - 3799€</p>
                    <p>Trek dans l'Himalaya et découverte des temples...</p>
                    <div class="circuit-actions">
                        <a href="../php/cart/add_to_cart.php?circuit_id=17" class="add-to-cart-btn">Ajouter au panier</a>
                        <a href="circuits/circuit17.php" class="details-btn">Voir détails</a>
                    </div>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Les mieux notés</h2>



                <div class="circuit-item">



                    <h3>Circuit 4 - Angleterre</h3>
                    <p>8 jours - 1800€</p>
                    <p>Votre voyage commence à Bath...</p>
                </div>
                <div class="circuit-item">




                    <h3>Circuit 7 - Tibet</h3>
                    <p>16 jours - 4299€</p>
                    <p>Découvrez les monastères du toit du monde...</p>
                </div>
            </div>

            <div class="circuit">
                <h2>Sélection aléatoire</h2>




                <?php foreach($circuits_aleatoires as $circuit): ?>




                <div class="circuit-item">
        <h3>Circuit <?php echo $circuit['id']; ?> - <?php echo $circuit['titre']; ?></h3>
      <p><?php echo $circuit['duree']; ?> jours - <?php echo $circuit['prix']; ?>€</p>
                    <p><?php echo $circuit['description']; ?></p>
                    <div class="circuit-actions">
                        <a href="../php/cart/add_to_cart.php?circuit_id=<?php echo $circuit['id']; ?>" class="add-to-cart-btn">Ajouter au panier</a>
                        <a href="circuits/circuit<?php echo $circuit['id']; ?>.php" class="details-btn">Voir détails</a>
                    </div>
                </div>




                <?php endforeach; ?>
            </div>
        </div>



        <h1>Découvrez nos circuits</h1>
        <div class="circuits-conteneur">



            <div class="circuit">
                <h2>Circuit 1</h2>
                <p>Durée : 15 jours</p>
                <p>Prix : 4789€</p>
                <p>Moyens de locomotion : bateau et/ou avion</p>
                <p>Le voyage débute à Kyoto...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=1" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit1.php" class="details-btn">Voir détails</a>
                </div>
            </div>



            <div class="circuit">
                <h2>Circuit 2</h2>
                <p>Durée : 20 jours</p>
                <p>Prix : 5989€</p>
                <p>Moyens de locomotion : bateau</p>
                <p>Le voyage débute au Caire...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=2" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit2.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 3</h2>
                <p>Durée : 11 jours</p>
                <p>Prix : 2289€</p>
                <p>Moyens de locomotion : train</p>
                <p>Bienvenue à Gênes...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=3" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit3.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 4</h2>
                <p>Durée : 8 jours</p>
                <p>Prix : 1800€</p>
                <p>Moyens de locomotion : bus et train</p>
                <p>Votre voyage commence à Bath...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=4" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit4.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 5</h2>
                <p>Durée : 13 jours</p>
                <p>Prix : 3999€</p>
                <p>Moyens de locomotion : bus et avion</p>
                <p>Découvrez les sites mayas...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=5" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit5.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 6</h2>
                <p>Durée : 10 jours</p>
                <p>Prix : 2999€</p>
                <p>Moyens de locomotion : voiture</p>
                <p>Explorez les Alpes...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=6" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit6.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 7</h2>
                <p>Durée : 16 jours</p>
                <p>Prix : 4299€</p>
                <p>Moyens de locomotion : train/bus</p>
                <p>Découvrez les monastères du toit du monde...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=7" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit7.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 8</h2>
                <p>Durée : 12 jours</p>
                <p>Prix : 3499€</p>
                <p>Moyens de locomotion : bus/bateau</p>
                <p>Explorez les temples d'Angkor...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=8" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit8.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 9</h2>
                <p>Durée : 14 jours.</p>
                <p>Prix : 4599€</p>
                <p>Moyens de locomotion : avion</p>
                <p>Découvrez les merveilles de l'Australie...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=9" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit9.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 10</h2>
                <p>Durée : 7 jours.</p>
                <p>Prix : 1999€</p>
                <p>Moyens de locomotion : train</p>
                <p>Visitez les châteaux de la Loire...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=10" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit10.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 11</h2>
                <p>Durée : 9 jours.</p>
                <p>Prix : 2599€</p>
                <p>Moyens de locomotion : bus</p>
                <p>Partez à la découverte de l'Andalousie...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=11" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit11.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 12</h2>
                <p>Durée : 16 jours.</p>
                <p>Prix : 4999€</p>
                <p>Moyens de locomotion : bateau</p>
                <p>Explorez les fjords de Norvège...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=12" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit12.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 13</h2>
                <p>Durée : 18 jours</p>
                <p>Prix : 5499€</p>
                <p>Moyens de locomotion : avion</p>
                <p>Découvrez les merveilles de l'Amérique du Sud...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=13" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit13.php" class="details-btn">Voir détails</a>
                </div>
            </div>

            <div class="circuit">
                <h2>Circuit 14</h2>
                <p>Durée : 21 jours</p>
                <p>Prix : 5999€</p>
                <p>Moyens de locomotion : bateau et avion</p>
                <p>Partez à l'aventure en Antarctique...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=14" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit14.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 15</h2>
                <p>Durée : 18 jours,</p>
                <p>Prix : 4899€</p>
                <p>Moyens de locomotion : train</p>
                <p>Le Transsibérien de Moscou à Vladivostok...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=15" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit15.php" class="details-btn">Voir détails</a>
                </div>
            </div>

            <div class="circuit">
                <h2>Circuit 16</h2>
                <p>Durée : 14 jours</p>
                <p>Prix : 3999€</p>
                <p>Moyens de locomotion : 4x4/train</p>
                <p>Les steppes mongoles et la vie nomade...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=16" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit16.php" class="details-btn">Voir détails</a>
                </div>
            </div>
            
            <div class="circuit">
                <h2>Circuit 17</h2>
                <p>Durée : 15 jours</p>
                <p>Prix : 3799€</p>
                <p>Moyens de locomotion : bus/avion</p>
                <p>Trek dans l'Himalaya et découverte des temples...</p>
                <div class="circuit-actions">
                    <a href="../php/cart/add_to_cart.php?circuit_id=17" class="add-to-cart-btn">Ajouter au panier</a>
                    <a href="circuits/circuit17.php" class="details-btn">Voir détails</a>
                </div>
            </div>
        </div>
        <div class="conteneur">
            <h1>L'équipe</h1>
            <section class="membres">



           <div class="cartes">
                    <div class="nom-membre">AGBAVOR Emmanuel</div>
           <div class="role-membre">Membre de l'équipe</div>
                </div>
                <div class="cartes">
                    <div class="nom-membre">BRINGUIER Valérian</div>
                    <div class="role-membre">Membre de l'équipe</div>
   </div>
                <div class="cartes">




                    <div class="nom-membre">HOUIDI ADEM</div>
                    <div class="role-membre">Membre de l'équipe</div>


     </div>
            </section>



        </div>
 <div class="conteneur">


            <h1>Nos retours</h1>


        </div>
        <footer>


     <a href="page.php"><img src="../img/twitter.jpg"></a>
            <a href="page.php"><img src="../img/insta.jpg"></a>
  <a href="page.php"><img src="../img/linkedin.jpg"></a>
        </footer>
    </div>



    <script src="../js/voyages.js"></script>
</body>

</html>
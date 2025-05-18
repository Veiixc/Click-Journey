<?php
require_once '../php/auth/check_auth.php';
require_once '../php/includes/functions.php';
requireAdmin();

// recherche
$search = isset($_GET['search']) ? trim($_GET['search']) : '';


$users_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


$users = readCSV(__DIR__ . '/../php/data/users.csv');


if (!empty($search)) {


    $users = array_filter($users, function($user) use ($search) {
   return stripos($user['login'], $search) !== false ||
        stripos($user['nom'], $search) !== false ||
        
        stripos($user['prenom'], $search) !== false ||
        stripos($user['email'], $search) !== false;
    });
}

$total_users = count($users);



$total_pages = ceil($total_users / $users_per_page);
$start = ($page - 1) * $users_per_page;


$users_slice = array_slice($users, $start, $users_per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <title>Administration</title>
    <link rel="icon" type="img/png" href="../img/logo-site.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="../js/admin.js" defer></script>
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
            <a href="cart.php"><button>Panier</button></a>
            <a href="profil.php"><button>Profil</button></a>
            <a href="../php/auth/logout.php"><button>Déconnexion</button></a>
        </div>
    </header>
    <div class="conteneur">
        <div class="conteneur-admin">
            <h1>Gestion des Utilisateurs</h1>
            <form method="GET" action="" class="search-form">
                <input type="text" name="search" class="barre-recherche" 
                       placeholder="Rechercher des utilisateurs..." 
                       value="<?php echo htmlspecialchars($search); ?>">
                       <button type="submit">Rechercher</button>
            </form>
            
            <?php if (!empty($search)): ?>
                <p>Résultats pour : "<?php echo htmlspecialchars($search); ?>"
                   <a href="?">Effacer la recherche</a>
                </p>
            <?php endif; ?>

            <table class="table-utilisateurs">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Informations</th>
                        <th>Statut</th>
                        <th>Date d'Inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users_slice as $user): 
                        $isBanned = $user['role'] === 'banned';
                        $isVip = $user['role'] === 'vip';
                        $rowStatus = $isBanned ? 'banned' : 'active';
                    ?>
                    <tr data-user-login="<?php echo htmlspecialchars($user['login']); ?>" data-status="<?php echo $rowStatus; ?>">
                        <td>
                            <div class="info-utilisateur">
                                <img src="../img/profil.svg" alt="Avatar utilisateur" class="avatar-utilisateur">
                                <div>
                                    <span><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></span><br>
                                    <span class="email-utilisateur"><?php echo htmlspecialchars($user['email']); ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="user-details">
                                <div>
                                    <strong>Nom:</strong> 
                                    <span class="editable" data-field-name="nom" data-field-type="text">
                                        <?php echo htmlspecialchars($user['nom']); ?>
                                    </span>
                                </div>
                                <div>
                                    <strong>Prénom:</strong> 
                                    <span class="editable" data-field-name="prenom" data-field-type="text">
                                        <?php echo htmlspecialchars($user['prenom']); ?>
                                    </span>
                                </div>
                                <div>
                                    <strong>Email:</strong> 
                                    <span class="editable" data-field-name="email" data-field-type="email">
                                        <?php echo htmlspecialchars($user['email']); ?>
                                    </span>
                                </div>
                                <div>
                                    <strong>Téléphone:</strong> 
                                    <span class="editable" data-field-name="telephone" data-field-type="tel">
                                        <?php echo htmlspecialchars($user['telephone']); ?>
                                    </span>
                                </div>
                                <div>
                                    <strong>Date de naissance:</strong> 
                                    <span class="editable" data-field-name="date_naissance" data-field-type="date">
                                        <?php echo htmlspecialchars($user['date_naissance']); ?>
                                    </span>
                                </div>
                                <div>
                                    <strong>Rôle:</strong> 
                                    <span class="editable" data-field-name="role" data-field-type="select" data-options="user,admin,vip,banned">
                                        <?php echo htmlspecialchars($user['role']); ?>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="statut <?php echo $isBanned ? 'banni' : 'actif'; ?>">
                                <?php echo $isBanned ? 'Banni' : 'Actif'; ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($user['date_inscription']); ?></td>
                        <td>
                            <button class="btn btn-vip">
                                <?php 
                                    if ($isBanned) {
                                        echo 'Rendre VIP';
                                    } else {
                                        echo $isVip ? 'Retirer VIP' : 'Rendre VIP';
                                    }
                                ?>
                            </button>
                            <button class="btn btn-bannir">
                                <?php echo $isBanned ? 'Débannir Utilisateur' : 'Bannir Utilisateur'; ?>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search='.urlencode($search) : ''; ?>" 
                       class="<?php echo ($page === $i) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>

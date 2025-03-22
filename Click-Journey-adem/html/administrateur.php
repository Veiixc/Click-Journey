<?php
require_once '../php/auth/check_auth.php';
require_once '../php/includes/functions.php';
requireAdmin();

// Récupérer le terme de recherche
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Configuration de la pagination
$users_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Lecture des utilisateurs depuis le CSV
$users = readCSV(__DIR__ . '/../php/data/users.csv');

// Filtrer les utilisateurs si un terme de recherche est présent
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

// Découpage pour la page courante
$users_slice = array_slice($users, $start, $users_per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Administrateur</title>
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
                        <th>Statut</th>
                        <th>Date d'Inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users_slice as $user): ?>
                    <tr>
                        <td>
                            <div class="info-utilisateur">
                                <img src="../img/profil.svg" alt="Avatar utilisateur" class="avatar-utilisateur">
                                <div>
                                    <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?><br>
                                    <span class="email-utilisateur"><?php echo htmlspecialchars($user['email']); ?></span>
                                </div>
                            </div>
                        </td>
                        <td><span class="statut actif">Actif</span></td>
                        <td><?php echo htmlspecialchars($user['date_inscription']); ?></td>
                        <td>
                            <button class="btn btn-vip">Rendre VIP</button>
                            <button class="btn btn-bannir">Bannir Utilisateur</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination -->
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

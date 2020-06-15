<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }
    include './db.php';
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>

<header>
    <div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item"> <h1><a href="./index.php" class="navbar-brand" title="Lien vers l'accueil">Onlycode</a></h1> </li>
<?php
try {
    if (isset($_SESSION['ROLE'])) {
        echo '<li class="nav-item">' . '<a class="nav-link" href="./leaderboard.php" title="Lien vers le classement">' . 'Classement' . '</a>' . '</li>';
        echo '<li class="nav-item">' . '<a class="nav-link" href="./message.php" title="Lien vers la messagerie">' . 'Messagerie' . '</a>' . '</li>';
        echo '<li class="nav-item">' . '<a class="nav-link" href="./profil.php" title="Lien vers votre profil">' . 'Profil' . '</a>' . '</li>';
        echo '<li class="nav-item">' . '<a class="nav-link" href="./logout.php" title="Lien de déconnexion">' . 'Déconnexion' . '</a>' . '</li>';

        if ($_SESSION['ROLE'] == 2) {
            echo '<li class="nav-item">' . '<a class="nav-link" href="./admin.php" title="Lien vers votre la page admin">' . "Page d'Admin" . '</a>' . '</li>';
        } elseif ($_SESSION['ROLE'] == 0) {
            echo '<li class="nav-item">' . '<a class="nav-link" href="./annonce.php" title="Page de création d annonce">' . "Créer une annonce" . '</a>' . '</li>';
        }

    } else {
        echo '<li class="nav-item">' . '<a class="nav-link" href="./login.php" title="Lien de connexion">' . 'Connexion' . '</a>' . '</li>';
        echo '<li class="nav-item">' . '<a class="nav-link" href="./register.php" title="Lien vers la page d inscription">' . "Inscription" . '</a>' . '</li>';
    }
} catch (PDOException $event) {
    die('Erreur : ' . $event->getMessage());
}
?>
            </ul>
        </nav>
    </div>
</header>
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
        <h1><a href="./index.php" title="Lien vers l'accueil">Onlycode</a></h1>

<?php
try {
    if (isset($_SESSION['ROLE'])) {?>
        <div>
            <form>
                <input type="text" name="search" placeholder="Rechercher...">
                <input type="submit" name="validsearch" value="🔍">
            </form>
        </div>
        <nav>
            <ul>
        <?php

        echo '<li>' . '<a href="./leaderboard.php" title="Lien vers le classement">' . 'Classement' . '</a>' . '</li>';
        echo '<li>' . '<a href="./profil.php" title="Lien vers votre profil">' . 'Profil' . '</a>' . '</li>';
        echo '<li>' . '<a href="./logout.php" title="Lien de déconnexion">' . 'Déconnexion' . '</a>' . '</li>';

        if ($_SESSION['ROLE'] == 2) {
            echo '<li>' . '<a href="./admin.php" title="Lien vers votre la page admin">' . "Page d'Admin" . '</a>' . '</li>';
        } elseif ($_SESSION['ROLE'] == 0) {
            echo '<li>' . '<a href="./annonce.php" title="Page de création d annonce">' . "Créer une annonce" . '</a>' . '</li>';
        }

    } else {
        echo '<li>' . '<a href="./login.php" title="Lien de connexion">' . 'Connexion' . '</a>' . '</li>';
        echo '<li>' . '<a href="./register.php" title="Lien vers la page d inscription">' . "Inscription" . '</a>' . '</li>';
    }
} catch (PDOException $event) {
    die('Erreur : ' . $event->getMessage());
}
?>
            </ul>
        </nav>
    </div>
</header>
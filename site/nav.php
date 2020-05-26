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

<header id="header">
    <div>
        <h1><a href="index.php" title="Lien vers l'accueil" id="home">Onlycode</a></h1>
        <nav>
            <ul>

<?php
try {
    if (isset($_SESSION['ROLE'])) {
        echo '<li>' . '<a href="./profil.php" title="Lien vers votre profil" id="profil">' . 'Profil' . '</a>' . '</li>';
        echo '<li>' . '<a href="./logout.php" title="Lien de déconnexion" id="logout">' . 'Déconnexion' . '</a>' . '</li>';

        if ($_SESSION['ROLE'] == 2) {
            echo '<li>' . '<a href="./admin.php" title="Lien vers votre la page admin" id="admin">' . "Page d'Admin" . '</a>' . '</li>';
        }

        if ($_SESSION['ROLE'] == 0) {
            echo '<li>' . '<a href="./annonce.php" title="Page de création d annonce" id="navannonce">' . "Créer une annonce" . '</a>' . '</li>';
        }

    } else {
        echo '<li>' . '<a href="./login.php" title="Lien de connexion" id="login">' . 'Connexion' . '</a>' . '</li>';
        echo '<li>' . '<a href="./register.php" title="Lien vers la page d inscription" id="register">' . "Inscription" . '</a>' . '</li>';
    }
} catch (PDOException $event) {
    die('Erreur : ' . $event->getMessage());
}
?>
            </ul>
        </nav>
    </div>
</header>
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
        <a href="index.php" title="Lien vers l'accueil" id="home">Site Emploi</a>
        <nav>
            <ul>

<?php
try {
    if (isset($_SESSION['ROLE'])) {
        echo '<li>' . '<a href="./profiles.php" title="Lien vers votre profil" id="profil">' . 'Profil' . '</a>' . '</li>';
        echo '<li>' . '<a href="./logout.php" title="Lien de déconnexion" id="logout">' . 'Déconnexion' . '</a>' . '</li>';

        if ($_SESSION['ROLE'] == 2) {
            echo '<li>' . '<a href="./admin.php" title="Lien vers votre la page admin" id="admin">' . "Page d'Admin" . '</a>' . '</li>';
        }

        if ($_SESSION['ROLE'] == 1) {
            echo '<li>' . '<a href="./offres.php" title="Page de création d offres" id="navoffres">' . "Créer une offre" . '</a>' . '</li>';
        }

        if ($_SESSION['ROLE'] == 0) {
            echo '<li>' . '<a href="./cvmaker.php" title="Page de création de CV" id="cvmaker">' . "Créer ou changer votre CV" . '</a>' . '</li>';
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
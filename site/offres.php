<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }

    include './db.php';

    if (!isset($_SESSION['ROLE']) or $_SESSION['ROLE'] != 1) {
        header("Location: http://localhost:8080/tp_php/login.php");
        exit;
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html>
    <?php include './head.php';?>
    <body>
        <?php include './nav.php';?>
        <div id="insc">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h2 class="card-title">Créer une offre</h2>
                    <p class="card-text">
                    <form method="post">
                        <div>
                            <label>Nom de l'emploi : </label>
                            <input type="text" name="emploi" placeholder="Nom de l'emploi" pattern="[^()/><\][\\\x22,;|éèç]+" required>
                        </div>
                        <div>
                            <label>Salaire : </label>
                            <input type="text" name="salaire" placeholder="Salaire" required>
                        </div>
                        <?php
try {
    include './db.php';

    if (isset($_SESSION['ERROR'])) {
        echo '<p>' . '* Nom de l offre vide ou salaire incorrect' . '</p>';
        unset($_SESSION['ERROR']);
    }

    if (isset($_POST['register'])) {
        $emploi = htmlspecialchars(strtolower($_POST['emploi']));
        $salaire = htmlspecialchars(strtolower($_POST['salaire']));
        $entreprise = htmlspecialchars(strtolower($_SESSION['EMAIL']));

        if ($salaire < 0) {
            echo 'test1';
            $_SESSION['ERROR'] = true;
            header("Location: http://localhost:8080/tp_php/offres.php");
            exit;
        }

        $requete1 = "INSERT INTO offres(emploi, salaire, entreprise) VALUES(?, ?, ?)";
        $query1 = $pdo->prepare($requete1);
        $query1->execute(array($emploi, $salaire, $entreprise));

        header("Location: http://localhost:8080/tp_php/index.php");

    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());

}
?>

                        <br>
                        <div>
                            <input id="boutonoffre" type="submit" name="register" value="Créer l'offre">
                        </div>
                    </form>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }

    include './db.php';

    if (!isset($_SESSION['ROLE']) or $_SESSION['ROLE'] != 1) {
        header('Location: http://localhost:8080/' . 'onlycode/site/405.php');
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
        <div id="annonce">
            <div style="width: 100%;">
                <div>
                    <h2>Créer une offre</h2>
                    <p>
                    <form method="post">
                        <?php
try {
    include './db.php';

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());

}
?>
                        <div>
                            <input type="submit" name="register" value="Créer l'annonce">
                        </div>
                    </form>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
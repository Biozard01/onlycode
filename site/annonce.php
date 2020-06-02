<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }

    include './db.php';

    if (!isset($_SESSION['ROLE']) or $_SESSION['ROLE'] != 0) {
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
        <div>
            <div style="width: 100%;">
                <div>
                    <h2>Créer une annonce</h2>
                    <form method="post">
                        <p>Titre de l'annonce : <input name="ann_name" type="text" required><p>
                        <p>Date d'expiration de l'annonce : <input name="ann_expire_time" type="datetime-local" max="9999-12-31T00:00" min="2020-06-02T00:00" required></p>
                        <p>Description de l'annonce : <p>
                        <textarea name="ann_text" cols="30" maxlength="1000" required></textarea>
                        <div>
                            <input type="submit" name="register" value="Créer l'annonce">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
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
                        <p>Titre de l'annonce : <input name="ann_name" type="text" required pattern="[^()/><\][\\\x22,;|éèç]+" spellcheck><p>
                        <p>Date d'expiration de l'annonce : <input name="ann_expire_time" type="datetime-local" required></p>
                        <p>Description de l'annonce : <p>
                        <textarea name="ann_text" cols="30" maxlength="1000" required spellcheck></textarea>
                        <?php
try {
    include './db.php';

    if (isset($_SESSION['ERROR'])) {
        echo '<p>' . "* Date d'expiration incorrect" . '</p>';
        unset($_SESSION['ERROR']);
    }

    if (isset($_POST['register'])) {
        $get_ann_name = htmlspecialchars(strtolower($_POST['ann_name']));
        $get_ann_expire_time = htmlspecialchars($_POST['ann_expire_time']);
        $get_ann_text = htmlspecialchars($_POST['ann_text']);
        $get_ann_lock_time = "0000-00-00 00:00:00";
        $get_ann_username = $_SESSION['USERNAME'];
        $get_is_ann_locked = 0;
        $get_ann_success = 0;
        $get_ann_views = 0;

        if ($get_ann_expire_time <= date("Y-m-d") . 't' . date("H:i")) {
            $_SESSION['ERROR'] = true;
            header('Location: http://localhost:8080/' . 'onlycode/site/annonce.php');
            exit;
        }

        $_SESSION['ANN_NAME'] = $get_ann_name;
        $_SESSION['ANN_USERNAME'] = $get_ann_username;
        $_SESSION['ANN_VIEWS'] = $get_ann_views;

        $requete1 = "INSERT INTO annonces(
        ann_name,
        ann_start_time,
        ann_expire_time,
        ann_text,
        ann_lock_time,
        is_ann_locked,
        ann_username,
        ann_success,
        ann_views)
        VALUES(?, NOW(), ?, ?, ?, ?, ?, ?, ?)";
        $query1 = $pdo->prepare($requete1);
        $query1->execute(array(
            $get_ann_name,
            $get_ann_expire_time,
            $get_ann_text,
            $get_ann_lock_time,
            $get_is_ann_locked,
            $get_ann_username,
            $get_ann_success,
            $get_ann_views));

    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());

}
?>
                        <div>
                            <input type="submit" name="register" value="Créer l'annonce">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }

    include './db.php';

    if (isset($_SESSION['ROLE'])) {
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
            <div style="width: 100%;">
                <h2>S'Inscrire</h2>
                <form method="post">
                    <div>
                        <label>Nom : </label>
                        <input type="text" name="nom" placeholder="Nom" pattern="[^()/><\][\\\x22,;|éèç]+" required>
                    </div>
                    <div>
                        <label>Prénom : </label>
                        <input type="text" name="prenom" pattern="[^()/><\][\\\x22,;|éèç]+" placeholder="Prenom" required>
                    </div>
                    <div>
                        <label>Pseudo : </label>
                        <input type="text" name="username" pattern="[^()/><\][\\\x22,;|éèç]+" placeholder="Pseudo" required>
                    </div>
                    <div>
                        <label>Email : </label>
                        <input type="email" name="email" pattern="[^()/><\][\\\x22,;|éèç]+" placeholder="Email" required>
                    </div>
                    <?php
try {
    include './db.php';

    if (isset($_SESSION['ERROR'])) {
        echo '<p>' . '* Adresse email déjà utiliser' . '</p>';
        unset($_SESSION['ERROR']);
    }

    if (isset($_SESSION['ERROR1'])) {
        echo '<p>' . '* Pseudo déjà utiliser' . '</p>';
        unset($_SESSION['ERROR1']);
    }

    if (isset($_POST['register'])) {
        $get_nom = htmlspecialchars(strtolower($_POST['nom']));
        $get_prenom = htmlspecialchars(strtolower($_POST['prenom']));
        $get_username = htmlspecialchars($_POST['username']);
        $get_email = htmlspecialchars(strtolower($_POST['email']));
        $pass_hache = htmlspecialchars(password_hash($_POST['password'], PASSWORD_DEFAULT));
        $init_points = 0;

        $test_email = $pdo->prepare("SELECT email FROM users");
        $test_email->execute();
        $result = $test_email->fetchAll();

        foreach ($result as $cle => $valeur) {
            $email_cut = json_encode(array_slice($result, $cle, $valeur));
            $cle++;
            $str = $email_cut;
            $order = array("[", "{", "email", ":", "}", "]", '"', ',', '    ');
            $replace = '';

            $email_clean = str_replace($order, $replace, $str);

            if ($email_clean === $get_email) {
                $_SESSION['ERROR'] = true;
                header('Location: http://localhost:8080/' . 'onlycode/site/register.php');
                exit;
            }
        }

        $test_username = $pdo->prepare("SELECT username FROM users");
        $test_username->execute();
        $result = $test_username->fetchAll();

        foreach ($result as $cle => $valeur) {
            $username_clean = json_encode(array_slice($result, $cle, $valeur));
            $cle++;
            $str = $username_clean;
            $order = array("[", "{", "username", ":", "}", "]", '"', ',', '    ');
            $replace = '';

            $username_clean = str_replace($order, $replace, $str);

            if ($username_clean === $get_username) {
                $_SESSION['ERROR1'] = true;
                header('Location: http://localhost:8080/' . 'onlycode/site/register.php');
                exit;
            }
        }

        if (isset($_POST['dev'])) {
            $is_dev = 1;
            $is_show_leaderboard = 1;
            $add_dev = "INSERT INTO dev(dev_username, prog_lang, dev_bio)
            VALUES(?, ?, ?)";
            $send_dev = $pdo->prepare($add_dev);
            $send_dev->execute(array($get_username, null, null));

            $add_lead = "INSERT INTO leaderboard(lead_username, lead_point)
            VALUES(?, ?)";
            $send_lead = $pdo->prepare($add_lead);
            $send_lead->execute(array($get_username, $init_points));

        } else {
            $is_dev = 0;
            $is_show_leaderboard = 0;
        }

        $_SESSION['ID'] = $result['id'];
        $_SESSION['ROLE'] = $is_dev;
        $_SESSION['NOM'] = $get_nom;
        $_SESSION['PRENOM'] = $get_prenom;
        $_SESSION['EMAIL'] = $get_email;
        $_SESSION['USERNAME'] = $get_username;
        $_SESSION['POINTS'] = $init_points;
        $_SESSION['LEAD'] = $is_show_leaderboard;

        $requete1 = "INSERT INTO users(
            nom,
            prenom,
            email,
            username,
            mdp,
            user_role,
            points,
            register_date,
            show_leaderboard)
            VALUES(?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        $query1 = $pdo->prepare($requete1);
        $query1->execute(array($get_nom, $get_prenom, $get_email, $get_username, $pass_hache, $is_dev, $init_points, $is_show_leaderboard));

        header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());

}
?>
                <div>
                    <label>Mot de passe : </label>
                    <input type="password" name="password" placeholder="Mot de passe" required>
                </div>
                <br>
                <div>
                    <input type="checkbox" name="dev">
                    <label for="dev">Vous êtes un dev</label>
                </div>
                <br>
                <div>
                    <input type="submit" name="register" value="S'enregistrer">
                </div>
            </form>
            <h3><a href="./login.php">Vous avez déjà un compte ? <br> Connectez-vous.</a></h3>
        </div>
    </body>
</html>
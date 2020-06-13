<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['ROLE'])) {
        header('Location: http://localhost:8080/' . 'onlycode/site/405.php');
        exit;
    }
    include './db.php';
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
                <h2>Connexion</h2>
                <form method="post">
                    <div>
                        <label>Email : </label>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <br>
                    <div>
                        <label>Mot de passe : </label>
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>
                    <br>
                    <?php
try {
    include './db.php';

    if (isset($_SESSION['ERROR'])) {
        echo '<p>' . '* Mauvais identifiant ou mot de passe' . '</p>';
        unset($_SESSION['ERROR']);
    }

    if (isset($_POST['login'])) {
        $get_email_login = htmlspecialchars(strtolower($_POST['email']));

        $req = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $req->execute(array($get_email_login));
        $resultat = $req->fetch();

        $is_password_correct = password_verify($_POST['password'], $resultat['mdp']);

        if (!$resultat) {
            $_SESSION['ERROR'] = true;
            header('Location: http://localhost:8080/' . 'onlycode/site/login.php');

        } else {
            if ($is_password_correct) {

                $_SESSION['ROLE'] = $resultat['user_role'];
                $_SESSION['ID'] = $resultat['id'];
                $_SESSION['NOM'] = $resultat['nom'];
                $_SESSION['PRENOM'] = $resultat['prenom'];
                $_SESSION['EMAIL'] = $resultat['email'];
                $_SESSION['USERNAME'] = $resultat['username'];
                $_SESSION['POINTS'] = $resultat['points'];
                $_SESSION['LEAD'] = $resultat['show_leaderboard'];

                if ($_SESSION['ROLE'] != 2) {
                    header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');
                } else {
                    header('Location: http://localhost:8080/' . 'onlycode/site/admin.php');
                }
            } else {
                $_SESSION['ERROR'] = true;
                header('Location: http://localhost:8080/' . 'onlycode/site/login.php');
            }
        }
    }

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
                <div>
                    <input type="submit" name="login" value="Se connecter">
                </div>
            </form>
            <h3><a href="./register.php">Pas de compte ? <br> Inscrivez-vous.</a></h3>
        </div>
    </body>
</html>
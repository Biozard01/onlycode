<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['ROLE'])) {
        header("Location: http://localhost:8080/tp_php/profiles.php");
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
        <div id="connexion">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h2 class="card-title">Connexion</h2>
                    <p class="card-text">
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
                        <?php
try {
    include './db.php';

    if (isset($_SESSION['ERROR'])) {
        echo '<p>' . '* Mauvais identifiant ou mot de passe' . '</p>';
        unset($_SESSION['ERROR']);
    }

    if (isset($_POST['login'])) {
        $getemaillogin = htmlspecialchars(strtolower($_POST['email']));

        $req = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $req->execute(array($getemaillogin));
        $resultat = $req->fetch();

        $isPasswordCorrect = password_verify($_POST['password'], $resultat['passsword']);
        echo $resultat['rrole'];
        if (!$resultat) {
            $_SESSION['ERROR'] = true;
            header("Location: http://localhost:8080/tp_php/login.php");
        } else {
            if ($isPasswordCorrect) {
                $_SESSION['ROLE'] = $resultat['rrole'];
                $_SESSION['ID'] = $resultat['id'];
                $_SESSION['NOM'] = $resultat['nom'];
                $_SESSION['PRENOM'] = $resultat['prenom'];
                $_SESSION['EMAIL'] = $resultat['email'];
                if ($_SESSION['ROLE'] != 2) {
                    header("Location: http://localhost:8080/tp_php/profiles.php");
                } else {
                    header("Location: http://localhost:8080/tp_php/admin.php");
                }
            } else {
                $_SESSION['ERROR'] = true;
                header("Location: http://localhost:8080/tp_php/login.php");
            }
        }
    }

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());

}
?>
                        <br>
                        <div>
                            <input id="boutonco" type="submit" name="login" value="Se connecter">
                        </div>
                    </form>
                    <h3><a href="./register.php">Pas de compte ? <br> Inscrivez-vous.</a></h3>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
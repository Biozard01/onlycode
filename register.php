<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }

    include './db.php';

    if (isset($_SESSION['ROLE'])) {
        header("Location: http://localhost:8080/tp_php/profiles.php");
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
                    <h2 class="card-title">S'Inscrire</h2>
                    <p class="card-text">
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

    if (isset($_POST['register'])) {
        $nom = htmlspecialchars(strtolower($_POST['nom']));
        $prenom = htmlspecialchars(strtolower($_POST['prenom']));
        $GetEmail = htmlspecialchars(($_POST['email']));
        $pass_hache = htmlspecialchars(password_hash($_POST['password'], PASSWORD_DEFAULT));

        $TestEmail = $pdo->prepare("SELECT email FROM users");
        $TestEmail->execute();
        $result = $TestEmail->fetchAll();

        foreach ($result as $cle => $valeur) {
            $emailcut = json_encode(array_slice($result, $cle, $valeur));
            $cle++;
            $str = $emailcut;
            $order = array("[", "{", "email", ":", "}", "]", '"', ',', '    ');
            $replace = '';

            $emailclean = str_replace($order, $replace, $str);

            if ($emailclean === $GetEmail) {
                $_SESSION['ERROR'] = true;
                header("Location: http://localhost:8080/tp_php/register.php");
                exit;
            }
        }

        if (isset($_POST['entreprise'])) {
            $isEntreprise = 1;
        } else {
            $isEntreprise = 0;
        }

        $_SESSION['ID'] = $result['id'];
        $_SESSION['ROLE'] = $isEntreprise;
        $_SESSION['NOM'] = $nom;
        $_SESSION['PRENOM'] = $prenom;
        $_SESSION['EMAIL'] = $GetEmail;
        $GetEmail = htmlspecialchars(strtolower($_POST['email']));

        $requete1 = "INSERT INTO users(nom, prenom, email, passsword, rrole) VALUES(?, ?, ?, ?, ?)";
        $query1 = $pdo->prepare($requete1);
        $query1->execute(array($nom, $prenom, $GetEmail, $pass_hache, $isEntreprise));

        header("Location: http://localhost:8080/tp_php/profiles.php");

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
                            <input type="checkbox" name="entreprise">
                            <label for="entreprise">Vous êtes une entreprise</label>
                        </div>
                        <br>
                        <div>
                            <input id="boutoninsc" type="submit" name="register" value="S'enregistrer">
                        </div>
                    </form>
                    <h3><a href="./login.php">Vous avez déjà un compte ? <br> Connectez-vous.</a></h3>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
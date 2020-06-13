<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }
    include './db.php';

    if (isset($_SESSION['ROLE'])) {

        if (isset($_POST['cancel_email'])) {
            header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');
            exit;
        }

        if (isset($_POST['save_email'])) {
            $new_email = htmlspecialchars(strtolower($_POST['change_email']));

            $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $req->execute(array($_SESSION['ID']));
            $user = $req->fetch();

            $test_email = $pdo->prepare("SELECT email FROM users");
            $test_email->execute();
            $result = $test_email->fetchAll();

            foreach ($result as $cle => $valeur) {
                $email_cut = json_encode(array_slice($result, $cle, $valeur));
                $str = $email_cut;
                $order = array("[", "{", "email", ":", "}", "]", '"', ',', '    ');
                $replace = '';
                $email_clean = str_replace($order, $replace, $str);
                $cle++;

                if ($email_clean === $new_email or $new_email === '') {
                    $_SESSION['ERROR'] = true;
                    header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');
                    exit;
                }
            }

            $req1 = $pdo->prepare('UPDATE users SET email = ? WHERE id = ?');
            $req1->execute(array($new_email, $user['id']));
            $_SESSION['EMAIL'] = $new_email;

        }

    } else {
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
            <h2>Votre Profil</h2>
                <?php

if (isset($_SESSION['ERROR'])) {
    echo '<p>' . '* Adresse incorrect (déjà utiliser ou vide)' . '</p>';
    unset($_SESSION['ERROR']);
}
try {
    if (isset($_POST['modify_email'])) {?>

        <form method="post">
            <div>
                <label>Entrer votre nouvelle adresse email : </label>
                    <input type="text" name="change_email" placeholder="Nouvel email">
                    <br>
                    <br>
                    <input type="submit" name="save_email" value="Enregistrer">
                    <br>
                    <br>
                    <input type="submit" name="cancel_email" value="Annuler">
            </div>
        </form>
        <?php

    } else {?>

        <form method="post">
            <p>Pseudo actuel :  <?php echo $_SESSION['USERNAME'] ?></p>
            <p>Adresse email actuel :  <?php echo $_SESSION['EMAIL'] ?></p>
            <button type="submit" name="modify_email">Modifier votre email</button>

<?php
if ($_SESSION['ROLE'] == 1) {?>
    <p>Votre Bio : <?php

        $test_bio = $pdo->prepare('SELECT dev_bio FROM dev WHERE dev_username = ?');
        $test_bio->execute(array($_SESSION['USERNAME']));
        $result = $test_bio->fetchAll();

        foreach ($result as $cle => $valeur) {
            $bio_cut = json_encode(array_slice($result, $cle, $valeur));
            $str = $bio_cut;
            $order = array("[", "{", "dev_bio", ":", "}", "]", '"', ',', '    ');
            $replace = '';
            $bio_clean = str_replace($order, $replace, $str);

            $cle++;

            if ($bio_clean == "null") {
                echo "Pas de bio";
            } else {
                echo $bio_clean;
            }
        }?>
    </p>

    <input type="submit" name="add_bio" value="Modifier votre bio">
    <br>
    <br>

<?php
if (isset($_POST['valid_bio'])) {
            $new_bio = htmlspecialchars($_POST['bio']);

            $requete = "UPDATE dev SET dev_bio = ? WHERE dev_username =?";
            $query = $pdo->prepare($requete);
            $query->execute(array($new_bio, $_SESSION["USERNAME"]));
            header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');
        }?>

<?php
if (isset($_POST['add_bio'])) {?>
    <form method="post">
        <textarea name="bio" cols="30" maxlength="1000" spellcheck></textarea>
        <br>
        <br>
        <input type="submit" name="valid_bio" value="Valider">
    </form>

<?php
}?>

<?php
}
    }

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}?>
        </div>
    </body>
</html>

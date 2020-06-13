<?php
function no_special_char_str($string)
{
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string);
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/'), ' ', $string);
    return trim($string, ' ');
}

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
        if (isset($_POST['cancel_bio'])) {
            header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');
            exit;
        }
        if (isset($_POST['cancel_lang'])) {
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
            <br>
            <br>

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
            $new_bio = htmlspecialchars(no_special_char_str($_POST['bio']));

            $requete = "UPDATE dev SET dev_bio = ? WHERE dev_username =?";
            $query = $pdo->prepare($requete);
            $query->execute(array($new_bio, $_SESSION["USERNAME"]));
            header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');
        }?>

<?php
if (isset($_POST['add_bio'])) {?>
    <form method="post">
        <textarea name="bio" cols="30" maxlength="1000" spellcheck placeholder=""Vote bio...></textarea>
        <br>
        <br>
        <input type="submit" name="valid_bio" value="Valider">
        <input type="submit" name="cancel_bio" value="Annuler">
    </form>

<?php
}?>

<p>Vos langage de programmation : <?php

        $test_prog_lang = $pdo->prepare('SELECT prog_lang FROM dev WHERE dev_username = ?');
        $test_prog_lang->execute(array($_SESSION['USERNAME']));
        $result = $test_prog_lang->fetchAll();

        foreach ($result as $cle => $valeur) {
            $prog_lang_cut = json_encode(array_slice($result, $cle, $valeur));
            $str = $prog_lang_cut;
            $order = array("[", "{", "prog_lang", ":", "}", "]", '"', ',', '    ');
            $replace = '';
            $prog_lang_clean = str_replace($order, $replace, $str);

            $cle++;

            if ($prog_lang_clean == "null") {
                echo "Pas de language de programmation";
            } else {
                echo $prog_lang_clean;
            }
        }?>

    <br>
    <br>
    <input type="submit" name="add_prog_lang" value="Modifier vos langage de programmation">
    <br>
    <br>
<?php
if (isset($_POST['valid_prog_lang'])) {
            $new_lang = htmlspecialchars(no_special_char_str($_POST['lang']));

            $requete = "UPDATE dev SET prog_lang = ? WHERE dev_username =?";
            $query = $pdo->prepare($requete);
            $query->execute(array($new_lang, $_SESSION["USERNAME"]));
            header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');
        }

        if (isset($_POST['add_prog_lang'])) {?>
            <form method="post">
                <textarea name="lang" cols="30" maxlength="255" spellcheck placeholder=""Vos langage de programmation...></textarea>
                <br>
                <br>
                <input type="submit" name="valid_prog_lang" value="Valider">
                <input type="submit" name="cancel_lang" value="Annuler">
            </form>

<?php
}?>
</p>

<?php
if ($_SESSION['LEAD'] == 0) {?>
                <div>
                    <input type="checkbox" name="show_leaderboard">
                    <label for="show_leaderboard">Apparaître dans le leaderboard</label>
                    <input type="submit" name="lead" value="Valider">
                </div>
<?php
} else {?>
                <div>
                    <input type="checkbox" name="show_leaderboard" checked>
                    <label for="show_leaderboard">Apparaître dans le leaderboard</label>
                    <input type="submit" name="lead" value="Valider">
                </div>
<?php
}

        ?>
<?php

        if (isset($_POST['lead'])) {

            if (!isset($_POST['show_leaderboard'])) {
                $requete = "UPDATE users SET show_leaderboard = ? WHERE username =?";
                $query = $pdo->prepare($requete);
                $query->execute(array(0, $_SESSION["USERNAME"]));
                $_SESSION['LEAD'] = 0;
                header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');

            } else {
                $requete = "UPDATE users SET show_leaderboard = ? WHERE username =?";
                $query = $pdo->prepare($requete);
                $query->execute(array(1, $_SESSION["USERNAME"]));
                $_SESSION['LEAD'] = 1;
                header('Location: http://localhost:8080/' . 'onlycode/site/profil.php');
            }
        }

    }
    }

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}?>
        </div>
    </body>
</html>

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

    if (!isset($_SESSION['ROLE'])) {
        header('Location: http://localhost:8080/' . 'onlycode/site/405.php');
        exit;
    }

    include './db.php';

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<html>
<?php include './head.php';?>
    <body>
<?php include './nav.php';?>
        <h2>Message reçus</h2>
<?php
$show_title = $pdo->prepare("SELECT mp_title FROM mp WHERE mp_username_receiver = ? ORDER BY mp_id DESC");
$show_title->execute(array($_SESSION['USERNAME']));
$show2 = $show_title->fetchAll();

$show_name = $pdo->prepare("SELECT mp_username_sender FROM mp WHERE mp_username_receiver = ? ORDER BY mp_id DESC");
$show_name->execute(array($_SESSION['USERNAME']));
$show1 = $show_name->fetchAll();

$show_msg = $pdo->prepare("SELECT mp_message FROM mp WHERE mp_username_receiver = ? ORDER BY mp_id DESC");
$show_msg->execute(array($_SESSION['USERNAME']));
$show3 = $show_msg->fetchAll();

foreach ($show1 as $cle => $valeur) {
    $show_name_cut = json_encode(array_slice($show1, $cle, $valeur));
    $str1 = $show_name_cut;
    $order1 = array("[", "{", "mp_username_sender", ":", "}", "]", '"', ',', '    ');
    $replace1 = '';
    $show_name_clean = str_replace($order1, $replace1, $str1);

    $show_title_cut = json_encode(array_slice($show2, $cle, $valeur));
    $str2 = $show_title_cut;
    $order2 = array("[", "{", "mp_title", ":", "}", "]", '"', ',', '    ');
    $replace2 = '';
    $show_title_clean = str_replace($order2, $replace2, $str2);

    $show_msg_cut = json_encode(array_slice($show3, $cle, $valeur));
    $str3 = $show_msg_cut;
    $order3 = array("[", "{", "mp_message", ":", "}", "]", '"', ',', '    ');
    $replace3 = '';
    $show_msg_clean = str_replace($order3, $replace3, $str3);

    $cle++;

    echo '<p>' . "Nom de la conversation : " . $show_title_clean . '</p>';
    echo '<p>' . "Envoyeur : " . $show_name_clean . '</p>';
    echo '<p>' . "Contenu : " . $show_msg_clean . '</p>';
    echo '<hr>';
}

?>

<h2>Message envoyé</h2>

<?php
$show_title = $pdo->prepare("SELECT mp_title FROM mp WHERE mp_username_sender = ? ORDER BY mp_id DESC");
$show_title->execute(array($_SESSION['USERNAME']));
$show2 = $show_title->fetchAll();

$show_name = $pdo->prepare("SELECT mp_username_receiver FROM mp WHERE mp_username_sender = ? ORDER BY mp_id DESC");
$show_name->execute(array($_SESSION['USERNAME']));
$show1 = $show_name->fetchAll();

$show_msg = $pdo->prepare("SELECT mp_message FROM mp WHERE mp_username_sender = ? ORDER BY mp_id DESC");
$show_msg->execute(array($_SESSION['USERNAME']));
$show3 = $show_msg->fetchAll();

foreach ($show1 as $cle => $valeur) {
    $show_name_cut = json_encode(array_slice($show1, $cle, $valeur));
    $str1 = $show_name_cut;
    $order1 = array("[", "{", "mp_username_receiver", ":", "}", "]", '"', ',', '    ');
    $replace1 = '';
    $show_name_clean = str_replace($order1, $replace1, $str1);

    $show_title_cut = json_encode(array_slice($show2, $cle, $valeur));
    $str2 = $show_title_cut;
    $order2 = array("[", "{", "mp_title", ":", "}", "]", '"', ',', '    ');
    $replace2 = '';
    $show_title_clean = str_replace($order2, $replace2, $str2);

    $show_msg_cut = json_encode(array_slice($show3, $cle, $valeur));
    $str3 = $show_msg_cut;
    $order3 = array("[", "{", "mp_message", ":", "}", "]", '"', ',', '    ');
    $replace3 = '';
    $show_msg_clean = str_replace($order3, $replace3, $str3);

    $cle++;

    echo '<p>' . "Nom de la conversation : " . $show_title_clean . '</p>';
    echo '<p>' . "Destinataire : " . $show_name_clean . '</p>';
    echo '<p>' . "Contenu : " . $show_msg_clean . '</p>';
    echo '<hr>';
}

?>

<div>
    <div style="width: 100%;">
        <div>
            <h2>Envoyez un message</h2>
            <form method="post">
                <p>Nom de la conversation : <input name="mp_title" type="text" required pattern="[^()/><\][\\\x22,;|éèç]+" spellcheck><p>
                <p>Destinataire : <input name="mp_username_receiver" type="text" required></p>
                <p>Message : <p>
                <textarea name="mp_message" cols="30" maxlength="1000" required spellcheck></textarea>
                <?php
try {
    include './db.php';

    if (isset($_SESSION['ERROR'])) {
        echo '<p>' . "* Destinataire incorrect" . '</p>';
        unset($_SESSION['ERROR']);
    }

    if (isset($_SESSION['ERROR1'])) {
        echo '<p>' . "* Cet utilisateur ne vous à pas envoyez de message" . '</p>';
        unset($_SESSION['ERROR1']);
    }

    if (isset($_POST['register'])) {
        $get_mp_title = htmlspecialchars($_POST['mp_title']);
        $get_mp_username_receiver = htmlspecialchars($_POST['mp_username_receiver']);
        $get_mp_message = htmlspecialchars(no_special_char_str($_POST['mp_message']));
        $get_mp_username_sender = $_SESSION['USERNAME'];

        if ($_SESSION['ROLE'] == 1) {
            $test_username0 = $pdo->prepare("SELECT username FROM users WHERE user_role = ?");
            $test_username0->execute(array(0));
            $result = $test_username0->fetchAll();

            $test_if_not_new = $pdo->prepare("SELECT mp_username_sender FROM mp WHERE mp_username_receiver = ?");
            $test_if_not_new->execute(array($_SESSION['USERNAME']));
            $result0 = $test_if_not_new->fetchAll();

            foreach ($result as $cle => $valeur) {
                $username_cut1 = json_encode(array_slice($result, $cle, $valeur));
                $str1 = $username_cut1;
                $order1 = array("[", "{", "username", ":", "}", "]", '"', ',', '    ');
                $replace1 = '';
                $username_clean1 = str_replace($order1, $replace1, $str1);

                $if_not_new_cut = json_encode(array_slice($result0, $cle, $valeur));
                $str0 = $if_not_new_cut;
                $order0 = array("[", "{", "mp_username_sender", ":", "}", "]", '"', ',', '    ');
                $replace0 = '';
                $if_not_new_clean = str_replace($order0, $replace0, $str0);

                $cle++;

                if ($if_not_new_clean == $get_mp_username_receiver) {
                    $_SESSION['ERROR1'] = true;
                    header('Location: http://localhost:8080/' . 'onlycode/site/message.php');
                    exit;
                }

                if ($username_clean == $get_mp_username_receiver) {
                    $_SESSION['ERROR'] = true;
                    header('Location: http://localhost:8080/' . 'onlycode/site/message.php');
                    exit;

                } else {
                    $requete1 = "INSERT INTO mp(mp_title, mp_username_sender, mp_message, mp_username_receiver) VALUES(?, ?, ?, ?)";
                    $query1 = $pdo->prepare($requete1);
                    $query1->execute(array($get_mp_title, $get_mp_username_sender, $get_mp_message, $get_mp_username_receiver));
                    header('Location: http://localhost:8080/' . 'onlycode/site/message.php');
                    exit;
                }
            }

        } else {
            $test_username = $pdo->prepare("SELECT username FROM users WHERE user_role = ?");
            $test_username->execute(array(1));
            $result1 = $test_username->fetchAll();

            foreach ($result1 as $cle => $valeur) {
                $username_cut = json_encode(array_slice($result1, $cle, $valeur));
                $str2 = $username_cut;
                $order2 = array("[", "{", "username", ":", "}", "]", '"', ',', '    ');
                $replace2 = '';
                $username_clean = str_replace($order2, $replace2, $str2);

                $cle++;

                if ($username_clean == $get_mp_username_receiver) {
                    $_SESSION['ERROR'] = true;
                    header('Location: http://localhost:8080/' . 'onlycode/site/message.php');
                    exit;

                } else {
                    $requete1 = "INSERT INTO mp(mp_title, mp_username_sender, mp_message, mp_username_receiver) VALUES(?, ?, ?, ?)";
                    $query1 = $pdo->prepare($requete1);
                    $query1->execute(array($get_mp_title, $get_mp_username_sender, $get_mp_message, $get_mp_username_receiver));
                    header('Location: http://localhost:8080/' . 'onlycode/site/message.php');
                    exit;
                }
            }

        }

    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());

}
?>
                        <div>
                            <input type="submit" name="register" value="Envoyez le message">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
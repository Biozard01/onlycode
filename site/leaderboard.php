<?php
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

<!DOCTYPE html>
<html>
    <?php include './head.php';?>
    <body>

<?php

include './nav.php';

$test_lead_username = $pdo->prepare('SELECT lead_username FROM leaderboard ORDER BY lead_point DESC');
$test_lead_username->execute();
$result0 = $test_lead_username->fetchAll();

$test_lead_point = $pdo->prepare('SELECT lead_point FROM leaderboard  ORDER BY lead_point DESC');
$test_lead_point->execute();
$result1 = $test_lead_point->fetchAll();

foreach ($result0 as $cle => $valeur) {
    $test_lead_username_cut = json_encode(array_slice($result0, $cle, $valeur));
    $str0 = $test_lead_username_cut;
    $order0 = array("[", "{", "lead_username", ":", "}", "]", '"', ',', '    ');
    $replace0 = '';
    $test_lead_username_clean = str_replace($order0, $replace0, $str0);

    $test_lead_point_cut = json_encode(array_slice($result1, $cle, $valeur));
    $str1 = $test_lead_point_cut;
    $order1 = array("[", "{", "lead_point", ":", "}", "]", '"', ',', '    ');
    $replace1 = '';
    $test_lead_point_clean = str_replace($order1, $replace1, $str1);

    $test_show_lead = $pdo->prepare('SELECT show_leaderboard FROM users WHERE username = ?');
    $test_show_lead->execute(array($test_lead_username_clean));
    $query0 = $test_show_lead->fetchAll();

    foreach ($query0 as $cle => $valeur) {
        $test_show_lead_cut = json_encode(array_slice($query0, $cle, $valeur));
        $str2 = $test_show_lead_cut;
        $order2 = array("[", "{", "show_leaderboard", ":", "}", "]", '"', ',', '    ');
        $replace2 = '';
        $test_show_lead_clean = str_replace($order2, $replace2, $str2);

        $cle++;
    }

    $cle++;

    if ($test_show_lead_clean == 1) {

        echo "Pseudo : " . $test_lead_username_clean;
        echo '<br>';
        echo "Points : " . $test_lead_point_clean;
        echo '<br>';
    }
}

?>
    </body>
</html>
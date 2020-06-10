<?php
try {
    if (!isset($_SESSION)) {
        session_start();
    }
    include './db.php';
    include './head.php';

    if (!isset($_SESSION['ROLE']) or $_SESSION['ROLE'] != 1) {
        header('Location: http://localhost:8080/' . 'onlycode/site/405.php');
        exit;
    }

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>

<div>
    <div style="width: 100%;">
    <?php

$annonce = $pdo->prepare("SELECT ann_name FROM annonces");
$annonce->execute();
$result = $annonce->fetchAll();

$views = $pdo->prepare("SELECT ann_views FROM annonces");
$views->execute();
$result1 = $views->fetchAll();

$username = $pdo->prepare("SELECT ann_username FROM annonces");
$username->execute();
$result2 = $username->fetchAll();

$desc = $pdo->prepare("SELECT ann_text FROM annonces");
$desc->execute();
$result3 = $desc->fetchAll();

foreach ($result as $cle => $valeur) {
    $ann_name_cut = json_encode(array_slice($result, $cle, $valeur));
    $str = $ann_name_cut;
    $order = array("[", "{", "ann_name", ":", "}", "]", '"', ',');
    $replace = '';
    $ann_name_clean = str_replace($order, $replace, $str);

    $ann_views_cut = json_encode(array_slice($result1, $cle, $valeur));
    $str = $ann_views_cut;
    $order = array("[", "{", "ann_views", ":", "}", "]", '"', ',');
    $replace = '';
    $ann_views_clean = str_replace($order, $replace, $str);

    $ann_username_cut = json_encode(array_slice($result2, $cle, $valeur));
    $str = $ann_username_cut;
    $order = array("[", "{", "ann_username", ":", "}", "]", '"', ',');
    $replace = '';
    $ann_username_clean = str_replace($order, $replace, $str);

    $ann_text_cut = json_encode(array_slice($result3, $cle, $valeur));
    $str = $ann_text_cut;
    $order = array("[", "{", "ann_text", ":", "}", "]", '"', ',');
    $replace = '';
    $ann_text_clean = str_replace($order, $replace, $str);

    $cle++;

    $id = $pdo->prepare("SELECT ann_id FROM annonces");
    $id->execute();
    $result_id = $id->fetchAll();

    $_SESSION['ANN_ID'] = $result_id;

    echo '<hr>';
    echo '<p>' . "Nom de l'annonce : " . $ann_name_clean . ' | ' . "Nombre de vues : " . $ann_views_clean . ' | '
        . "Nom d'utilisateur de l'annonceur : " . $ann_username_clean . '</p>';
    echo '<p>' . $ann_text_clean . '</p>';
}

?>
    </div>
</div>


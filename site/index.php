<?php
try {
    if (!isset($_SESSION)) {
        session_start();
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
include './show_ann.php';
?>
    </body>
</html>

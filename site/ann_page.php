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

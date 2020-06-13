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
        <?php include './nav.php';?>
        <h2>Interdiction d'être ici !</h2>
    </body>
</html>
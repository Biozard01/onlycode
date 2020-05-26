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
        <h2>Tu fais quoi ici le bouff ?</h2>
    </body>
</html>
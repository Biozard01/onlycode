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
        <?php include './nav.php';
try {

    if (isset($_SESSION['ROLE'])) {

        if ($_SESSION['ROLE'] == 1) {
            ?>

        <div id="offresdispo">
            <div style="width: 100%;">
                <div>
                    <h2>Vos offres disponible</h2>
                    <div id="offres">
<?php

            $offreemploi = $pdo->prepare("SELECT emploi FROM offres WHERE entreprise LIKE ?");
            $offreemploi->execute(array($_SESSION['EMAIL']));
            $result = $offreemploi->fetchAll();

            $offresalaire = $pdo->prepare("SELECT salaire FROM offres WHERE entreprise LIKE ?");
            $offresalaire->execute(array($_SESSION['EMAIL']));
            $result1 = $offresalaire->fetchAll();

            foreach ($result as $cle => $valeur) {
                $emploicut = json_encode(array_slice($result, $cle, $valeur));

                $str = $emploicut;
                $order = array("[", "{", "emploi", ":", "}", "]", '"', ',');
                $replace = '';
                $salairecut = json_encode(array_slice($result1, $cle, $valeur));
                $str1 = $salairecut;
                $order1 = array("[", "{", "salaire", ":", "}", "]", '"', ',');
                $replace1 = '';

                $cle++;
                $emploiclean = str_replace($order, $replace, $str);
                $salaireclean = str_replace($order1, $replace1, $str1);

                echo '<hr>';
                echo '<p>' . 'Nom de l emploi : ' . $emploiclean . '</p>';
                echo '<p>' . 'Salaire : ' . $salaireclean . '</p>';
                echo '<hr>';
            }
            ?>
                    </div>
                </div>
            </div>
        </div>

    <?php
}

        if ($_SESSION['ROLE'] == 0) {
            ?>
        <div id="offresdispo">
            <div style="width: 100%;">
                <div>
                    <h2>Offres disponible</h2>
                    <div id="offres">
<?php

            $offreemploi = $pdo->prepare("SELECT emploi FROM offres");
            $offreemploi->execute();
            $result = $offreemploi->fetchAll();

            $offresalaire = $pdo->prepare("SELECT salaire FROM offres");
            $offresalaire->execute();
            $result1 = $offresalaire->fetchAll();

            $offreentreprise = $pdo->prepare("SELECT entreprise FROM offres");
            $offreentreprise->execute();
            $result2 = $offreentreprise->fetchAll();

            foreach ($result as $cle => $valeur) {
                $emploicut = json_encode(array_slice($result, $cle, $valeur));

                $str = $emploicut;
                $order = array("[", "{", "emploi", ":", "}", "]", '"', ',');
                $replace = '';

                $salairecut = json_encode(array_slice($result1, $cle, $valeur));
                $str1 = $salairecut;
                $order1 = array("[", "{", "salaire", ":", "}", "]", '"', ',');
                $replace1 = '';

                $entreprisecut = json_encode(array_slice($result2, $cle, $valeur));
                $str2 = $entreprisecut;
                $order2 = array("[", "{", "entreprise", ":", "}", "]", '"', ',');
                $replace2 = '';

                $cle++;

                $emploiclean = str_replace($order, $replace, $str);
                $salaireclean = str_replace($order1, $replace1, $str1);
                $entrepriseclean = str_replace($order2, $replace2, $str2);

                echo '<hr>';
                echo '<p>' . 'Nom de l emploi : ' . $emploiclean . '</p>';
                echo '<p>' . 'Email de l entreprise : ' . $entrepriseclean . '</p>';
                echo '<p>' . 'Salaire : ' . $salaireclean . '</p>';
                echo '<hr>';
            }
            ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
}
    }

} catch (PDOException $event) {
    die('Erreur : ' . $event->getMessage());
}

?>
    </body>
</html>

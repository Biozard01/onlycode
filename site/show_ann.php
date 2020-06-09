<?php
if (!isset($_SESSION['ROLE'])) {
    header('Location: http://localhost:8080/' . 'onlycode/site/405.php');
    exit;
}

try {
    if (isset($_SESSION['ROLE'])) {
        if ($_SESSION['ROLE'] == 0) {?>
        <div>
            <div style="width: 100%;">
                <h2>Vos annonces encore disponible</h2>
<?php

            $annonce = $pdo->prepare("SELECT ann_name FROM annonces WHERE ann_username LIKE ?");
            $annonce->execute(array($_SESSION['USERNAME']));
            $result = $annonce->fetchAll();

            $dispo_or_not = $pdo->prepare("SELECT is_ann_locked FROM annonces WHERE ann_username LIKE ?");
            $dispo_or_not->execute(array($_SESSION['USERNAME']));
            $result0 = $dispo_or_not->fetchAll();

            $views = $pdo->prepare("SELECT ann_views FROM annonces WHERE ann_username LIKE ?");
            $views->execute(array($_SESSION['USERNAME']));
            $result1 = $views->fetchAll();

            foreach ($result as $cle => $valeur) {

                $dispo_or_not_cut = json_encode(array_slice($result0, $cle, $valeur));

                $str = $dispo_or_not_cut;
                $order = array("[", "{", "is_ann_locked", ":", "}", "]", '"', ',');
                $replace = '';

                $dispo_or_not_clean = str_replace($order, $replace, $str);

                if ($dispo_or_not_clean == 0) {

                    $ann_name_cut = json_encode(array_slice($result, $cle, $valeur));
                    $str = $ann_name_cut;
                    $order = array("[", "{", "ann_name", ":", "}", "]", '"', ',');
                    $replace = '';
                    $ann_name_clean = str_replace($order, $replace, $str);

                    $ann_views_cut = json_encode(array_slice($result1, $cle, $valeur));
                    $str = $ann_views_cut;
                    $order = array("[", "{", "ann_views", ":", "}", "]", '"', ',');
                    $replace = '';

                    $cle++;
                    $ann_views_clean = str_replace($order, $replace, $str);

                    echo '<hr>';
                    echo '<p>' . "Nom de l'annonce : " . $ann_name_clean . ' | ' . "Nombre de vues : " . $ann_views_clean . '</p>';

                } else {
                }
            }

            ?>
        </div>
    </div>

    <div>
        <div style="width: 100%;">
            <h2>Toutes vos annonces</h2>
            <?php

            $annonce = $pdo->prepare("SELECT ann_name FROM annonces WHERE ann_username LIKE ?");
            $annonce->execute(array($_SESSION['USERNAME']));
            $result = $annonce->fetchAll();

            $views = $pdo->prepare("SELECT ann_views FROM annonces WHERE ann_username LIKE ?");
            $views->execute(array($_SESSION['USERNAME']));
            $result1 = $views->fetchAll();

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

                $cle++;
                $ann_views_clean = str_replace($order, $replace, $str);

                echo '<hr>';
                echo '<p>' . "Nom de l'annonce : " . $ann_name_clean . ' | ' . "Nombre de vues : " . $ann_views_clean . '</p>';
            }

            ?>
        </div>
    </div>

<?php
} elseif ($_SESSION['ROLE'] == 1) {?>

<div>
        <div style="width: 100%;">
            <h2>Toutes vos annonces</h2>
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

                $cle++;

                echo '<hr>';
                echo '<p>' . "Nom de l'annonce : " . $ann_name_clean . ' | ' . "Nombre de vues : " . $ann_views_clean . ' | '
                    . "Nom d'utilisateur de l'annonceur : " . $ann_username_clean . '</p>' .
                    "<a href='./ann_page.php' title='Voir l`annonce complète'>" . "<button href='./ann_page.php' title='Voir l`annonce complète'>" .
                    "Show" . '</button>' . '</a>';
            }

            ?>
        </div>
    </div>
    <?php
}
    }
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}?>

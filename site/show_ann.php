<?php
if (!isset($_SESSION)) {
    session_start();
}

include './db.php';

try {
    if (isset($_SESSION['ROLE'])) {
        /* Partie affichage pour les gens qui ont besoin d'aide */
        if ($_SESSION['ROLE'] == 0) {?>
        <div>
            <div style="width: 100%;">
                <h2>Vos annonces encore disponible</h2>
<?php

            $is_locked = $pdo->prepare("SELECT is_ann_locked FROM annonces WHERE ann_username LIKE ?");
            $is_locked->execute(array($_SESSION['USERNAME']));
            $result0 = $is_locked->fetchAll();

            $ann_name = $pdo->prepare("SELECT ann_name FROM annonces WHERE ann_username LIKE ?");
            $ann_name->execute(array($_SESSION['USERNAME']));
            $result1 = $ann_name->fetchAll();

            $views = $pdo->prepare("SELECT ann_views FROM annonces WHERE ann_username LIKE ?");
            $views->execute(array($_SESSION['USERNAME']));
            $result2 = $views->fetchAll();

            foreach ($result0 as $cle => $valeur) {

                $is_locked_cut = json_encode(array_slice($result0, $cle, $valeur));
                $str = $is_locked_cut;
                $order = array("[", "{", "is_ann_locked", ":", "}", "]", '"', ',');
                $replace = '';
                $is_locked_clean = str_replace($order, $replace, $str);

                if ($is_locked_clean == 0) {

                    $ann_name_cut = json_encode(array_slice($result1, $cle, $valeur));
                    $str = $ann_name_cut;
                    $order = array("[", "{", "ann_name", ":", "}", "]", '"', ',');
                    $replace = '';
                    $ann_name_clean = str_replace($order, $replace, $str);

                    $ann_views_cut = json_encode(array_slice($result2, $cle, $valeur));
                    $str = $ann_views_cut;
                    $order = array("[", "{", "ann_views", ":", "}", "]", '"', ',');
                    $replace = '';
                    $ann_views_clean = str_replace($order, $replace, $str);

                    $cle++;

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

<!-- Partie affichage pour les dev -->

<?php
} elseif ($_SESSION['ROLE'] == 1) {?>

<div>
    <div style="width: 100%;">
        <h2>Toutes les annonces disponible</h2>

<?php

            $is_locked = $pdo->prepare("SELECT is_ann_locked FROM annonces");
            $is_locked->execute();
            $result0 = $is_locked->fetchAll();

            $ann_name = $pdo->prepare("SELECT ann_name FROM annonces");
            $ann_name->execute();
            $result1 = $ann_name->fetchAll();

            $views = $pdo->prepare("SELECT ann_views FROM annonces");
            $views->execute();
            $result2 = $views->fetchAll();

            $username = $pdo->prepare("SELECT ann_username FROM annonces");
            $username->execute();
            $result3 = $username->fetchAll();

            $ann_text = $pdo->prepare("SELECT ann_text FROM annonces");
            $ann_text->execute();
            $result4 = $ann_text->fetchAll();

            $ann_lock_time1 = $pdo->prepare("SELECT ann_lock_time FROM annonces");
            $ann_lock_time1->execute();
            $result5 = $ann_lock_time1->fetchAll();

            $ann_id1 = $pdo->prepare("SELECT ann_id FROM annonces");
            $ann_id1->execute();
            $result6 = $ann_id1->fetchAll();

            foreach ($result0 as $cle => $valeur) {

                $is_locked_cut = json_encode(array_slice($result0, $cle, $valeur));
                $str0 = $is_locked_cut;
                $order0 = array("[", "{", "is_ann_locked", ":", "}", "]", '"', ',');
                $replace0 = '';
                $is_locked_clean = str_replace($order0, $replace0, $str0);

                if ($is_locked_clean == 0) {

                    $ann_name_cut = json_encode(array_slice($result1, $cle, $valeur));
                    $str1 = $ann_name_cut;
                    $order1 = array("[", "{", "ann_name", ":", "}", "]", '"', ',');
                    $replace1 = '';
                    $ann_name_clean = str_replace($order1, $replace1, $str1);

                    $ann_views_cut = json_encode(array_slice($result2, $cle, $valeur));
                    $str2 = $ann_views_cut;
                    $order2 = array("[", "{", "ann_views", ":", "}", "]", '"', ',');
                    $replace2 = '';
                    $ann_views_clean = str_replace($order2, $replace2, $str2);

                    $ann_username_cut = json_encode(array_slice($result3, $cle, $valeur));
                    $str3 = $ann_username_cut;
                    $order3 = array("[", "{", "ann_username", ":", "}", "]", '"', ',');
                    $replace3 = '';
                    $ann_username_clean = str_replace($order3, $replace3, $str3);

                    $ann_text_cut = json_encode(array_slice($result4, $cle, $valeur));
                    $str4 = $ann_text_cut;
                    $order4 = array("[", "{", "ann_text", ":", "}", "]", '"', ',');
                    $replace4 = '';
                    $ann_text_clean = str_replace($order4, $replace4, $str4);

                    $ann_lock_time_cut1 = json_encode(array_slice($result5, $cle, $valeur));
                    $str5 = $ann_lock_time_cut1;
                    $order5 = array("[", "{", "ann_lock_time", ":", "}", "]", '"', ',');
                    $replace5 = '';
                    $ann_lock_time_clean1 = str_replace($order5, $replace5, $str5);

                    $ann_id_cut1 = json_encode(array_slice($result6, $cle, $valeur));
                    $str6 = $ann_id_cut1;
                    $order6 = array("[", "{", "ann_id", ":", "}", "]", '"', ',');
                    $replace6 = '';
                    $ann_id_clean1 = str_replace($order6, $replace6, $str6);

                    $cle++;

                    echo '<hr>';
                    echo '<p>' . "Nom de l'annonce : " . $ann_name_clean . ' | ' . 'Nombre de vues : ' . $ann_views_clean . ' | ' .
                        "Nom d'utilisateur de l'annonceur : " . $ann_username_clean . '</p>';
                    echo '<p>' . 'Description : ' . $ann_text_clean . '</p>';

                    ?>

            <form method="post">
                <div>
                    <input type="checkbox" name="ann_chose">
                    <label for="ann_chose">Choisir cette annonce</label>
                    <input type="submit" name="acc_ann" value="Accepter l'annonce">
                </div>
            </from>

            <?php

                }

                if (isset($_POST['acc_ann'])) {

                    if (isset($_POST['ann_chose'])) {
                        foreach ($result6 as $cle => $valeur) {
                            $requete0 = "UPDATE annonces SET is_ann_locked = ? WHERE ann_id = ?";
                            $query0 = $pdo->prepare($requete0);
                            $query0->execute(array(1, $ann_id_clean1));

                            $requete1 = "UPDATE annonces SET ann_dev_username = ? WHERE ann_id = ?";
                            $query1 = $pdo->prepare($requete1);
                            $query1->execute(array($_SESSION['USERNAME'], $ann_id_clean1));

                            header('Location: http://localhost:8080/' . 'onlycode/site/index.php');
                        }
                    }

                }

            }

            ?>
        </div>
    </div>

<!-- Partie affichage pour les dev num 2 -->
<div>
    <div style="width: 100%;">
        <h2>Vos annonces en cour</h2>

        <?php

            $is_locked = $pdo->prepare("SELECT is_ann_locked FROM annonces");
            $is_locked->execute();
            $result0 = $is_locked->fetchAll();

            $ann_name = $pdo->prepare("SELECT ann_name FROM annonces WHERE ann_dev_username = ?");
            $ann_name->execute(array($_SESSION['USERNAME']));
            $result1 = $ann_name->fetchAll();

            $views = $pdo->prepare("SELECT ann_views FROM annonces WHERE ann_dev_username = ?");
            $views->execute(array($_SESSION['USERNAME']));
            $result2 = $views->fetchAll();

            $username = $pdo->prepare("SELECT ann_username FROM annonces WHERE ann_dev_username = ?");
            $username->execute(array($_SESSION['USERNAME']));
            $result3 = $username->fetchAll();

            $ann_text = $pdo->prepare("SELECT ann_text FROM annonces WHERE ann_dev_username = ?");
            $ann_text->execute(array($_SESSION['USERNAME']));
            $result4 = $ann_text->fetchAll();

            $ann_lock_time1 = $pdo->prepare("SELECT ann_lock_time FROM annonces");
            $ann_lock_time1->execute();
            $result5 = $ann_lock_time1->fetchAll();

            $ann_dev_username = $pdo->prepare("SELECT ann_dev_username FROM annonces");
            $ann_dev_username->execute();
            $result6 = $ann_dev_username->fetchAll();

            foreach ($result0 as $cle => $valeur) {

                $is_locked_cut = json_encode(array_slice($result0, $cle, $valeur));
                $str0 = $is_locked_cut;
                $order0 = array("[", "{", "is_ann_locked", ":", "}", "]", '"', ',');
                $replace0 = '';
                $is_locked_clean = str_replace($order0, $replace0, $str0);

                $ann_name_cut = json_encode(array_slice($result1, $cle, $valeur));
                $str1 = $ann_name_cut;
                $order1 = array("[", "{", "ann_name", ":", "}", "]", '"', ',');
                $replace1 = '';
                $ann_name_clean = str_replace($order1, $replace1, $str1);

                $ann_views_cut = json_encode(array_slice($result2, $cle, $valeur));
                $str2 = $ann_views_cut;
                $order2 = array("[", "{", "ann_views", ":", "}", "]", '"', ',');
                $replace2 = '';
                $ann_views_clean = str_replace($order2, $replace2, $str2);

                $ann_username_cut = json_encode(array_slice($result3, $cle, $valeur));
                $str3 = $ann_username_cut;
                $order3 = array("[", "{", "ann_username", ":", "}", "]", '"', ',');
                $replace3 = '';
                $ann_username_clean = str_replace($order3, $replace3, $str3);

                $ann_text_cut = json_encode(array_slice($result4, $cle, $valeur));
                $str4 = $ann_text_cut;
                $order4 = array("[", "{", "ann_text", ":", "}", "]", '"', ',');
                $replace4 = '';
                $ann_text_clean = str_replace($order4, $replace4, $str4);

                $ann_lock_time_cut1 = json_encode(array_slice($result5, $cle, $valeur));
                $str5 = $ann_lock_time_cut1;
                $order5 = array("[", "{", "ann_lock_time", ":", "}", "]", '"', ',');
                $replace5 = '';
                $ann_lock_time_clean1 = str_replace($order5, $replace5, $str5);

                $ann_dev_username_cut = json_encode(array_slice($result6, $cle, $valeur));
                $str6 = $ann_dev_username_cut;
                $order6 = array("[", "{", "ann_dev_username", ":", "}", "]", '"', ',');
                $replace6 = '';
                $ann_dev_username_clean = str_replace($order6, $replace6, $str6);

                $cle++;

                if ($_SESSION['USERNAME'] == $ann_dev_username_clean) {

                    echo '<hr>';
                    echo '<p>' . "Nom de l'annonce : " . $ann_name_clean . ' | ' . 'Nombre de vues : ' . $ann_views_clean . ' | ' .
                        "Nom d'utilisateur de l'annonceur : " . $ann_username_clean . '</p>';
                    echo '<p>' . 'Description : ' . $ann_text_clean . '</p>';

                }

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

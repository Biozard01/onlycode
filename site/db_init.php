<?php

$database_host = 'localhost';
$database_port = '3306';
$database_dbname = 'onlycode';
$database_user = 'root';
$database_password = '';
$database_charset = 'UTF8';
$database_options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

$pdo = new PDO(
    'mysql:host=' . $database_host .
    ';port=' . $database_port .
    ';dbname=' . $database_dbname .
    ';charset=' . $database_charset,
    $database_user,
    $database_password,
    $database_options
);

try {
    $table_users = "CREATE TABLE IF NOT EXISTS onlycode.users (
        id INT NOT NULL AUTO_INCREMENT,
        nom VARCHAR(255) NOT NULL,
        prenom VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        username VARCHAR(255) NOT NULL,
        mdp VARCHAR(255) NOT NULL,
        user_role tinyint(2) NOT NULL,
        points int NOT NULL,
        register_date datetime NOT NULL,
        show_leaderboard tinyint(1) NOT NULL,
        PRIMARY KEY (id));";

    $query1 = $pdo->prepare($table_users);
    $query1->execute();

    $table_annonces = "CREATE TABLE IF NOT EXISTS onlycode.annonces (
        ann_id INT NOT NULL AUTO_INCREMENT,
        ann_name VARCHAR(255) NOT NULL,
        ann_start_time datetime NOT NULL,
        ann_expire_time datetime NOT NULL,
        ann_lock_time datetime NOT NULL,
        is_ann_locked tinyint(1) NULL,
        ann_username  VARCHAR(255) NOT NULL,
        ann_success  tinyint(1) NULL,
        ann_text VARCHAR(1000) NOT NULL,
        ann_views int NOT NULL,
        PRIMARY KEY (ann_id));";

    $query2 = $pdo->prepare($table_annonces);
    $query2->execute();

    $table_leaderboard = "CREATE TABLE IF NOT EXISTS onlycode.leaderboard (
        lead_id INT NOT NULL AUTO_INCREMENT,
        lead_username VARCHAR(255) NOT NULL,
        lead_point int NOT NULL,
        PRIMARY KEY (lead_id));";

    $query3 = $pdo->prepare($table_leaderboard);
    $query3->execute();

    $table_dev = "CREATE TABLE IF NOT EXISTS onlycode.dev (
        dev_id INT NOT NULL AUTO_INCREMENT,
        dev_username VARCHAR(255) NOT NULL,
        prog_lang VARCHAR(255) NULL,
        dev_bio VARCHAR(65535) NULL,
        PRIMARY KEY (dev_id));";

    $query4 = $pdo->prepare($table_dev);
    $query4->execute();

    $table_shop = "CREATE TABLE IF NOT EXISTS onlycode.shop (
        item_id INT NOT NULL AUTO_INCREMENT,
        item_name VARCHAR(255) NOT NULL,
        item_cost int NOT NULL,
        item_available tinyint(1) NULL,
        PRIMARY KEY (item_id));";

    $query5 = $pdo->prepare($table_dev);
    $query5->execute();

    $CreateAdmin = $pdo->prepare("SELECT email FROM users");
    $CreateAdmin->execute();
    $result = $CreateAdmin->fetchAll();

    if ($result <= array(1)) {

        $nom = "";
        $prenom = "";
        $email = "";
        $username = "";
        $mdp = "";
        $user_role = "";
        $points = "";
        $show_leaderboard = "";
        $create_admin = "INSERT INTO onlycode.users (
            nom,
            prenom,
            email,
            username,
            mdp,
            user_role,
            points,
            register_date,
            show_leaderboard)
        VALUES (:nom, :prenom, :email, :username, :mdp, :user_role, :points, NOW(), :show_leaderboard)";

        $send = $pdo->prepare($create_admin);
        $send->bindParam('nom', $nom);
        $send->bindParam('prenom', $prenom);
        $send->bindParam('email', $email);
        $send->bindParam('username', $username);
        $send->bindParam('mdp', $mdp);
        $send->bindParam('user_role', $user_role);
        $send->bindParam('points', $points);
        $send->bindParam('show_leaderboard', $show_leaderboard);
        $send->execute();

    }
    header('Location: http://localhost:8080/' . 'onlycode/site/index.php');

} catch (PDOException $event) {
    die('Erreur : ' . $event->getMessage());
}

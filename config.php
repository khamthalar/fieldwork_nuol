<?php
    $server_name = "localhost";
    $user_login = "root";
    $userpass = "";
    $database_name = "quiz_db";
    try {
        $dbcon = new PDO(
            "mysql:host=$server_name;dbname=$database_name", $user_login, $userpass, 
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
        );
        $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Faild to connect to database " . $e->getMessage();
    }
?>
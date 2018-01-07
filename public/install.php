<?php
/**
 * Created by PhpStorm.
 * User: alice
 * Date: 06.01.18
 * Time: 23:35
 */

    $settings = parse_ini_file("../config/db.ini.php");
    $dsn = 'mysql:dbname=' . $settings["dbname"] . ';host=' . $settings["host"] . '';
    $sql = file_get_contents("../data/world.sql");
    try {
        $connection = new PDO($dsn, $settings["user"], $settings["password"]);
        $connection->exec($sql);
        echo "Database and table users created successfully.";

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>

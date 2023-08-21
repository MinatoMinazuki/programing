<?php

function dbc(){
    $host = "localhost";
    $dbname = "sousaku";
    $user = "root";
    $pass = "root";

    $dns = "mysql:host=$host;dbname=$dbname;charset=utf8";

    try{
        $pdo = new PDO($dns, $user, $pass,
            [
                PDO::ATTER_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTER_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

        return $pdo;

    } catch(PDOException $e) {
        exit($e->getMessage());
    }
}

dbc();


?>
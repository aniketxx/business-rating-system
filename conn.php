<?php

$hostname = "localhost";
$dbname   = "business_rating";
$username = "root";
$password = "";

try {

    $conn = new PDO(
        "mysql:host=$hostname;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    die("Database connection failed");
}
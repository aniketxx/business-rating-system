<?php
require "../conn.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name    = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone   = $_POST['phone'] ?? '';
    $email   = $_POST['email'] ?? '';

    try{

        $stmt = $conn->prepare("
            INSERT INTO businesses (name,address,phone,email)
            VALUES (?,?,?,?)
        ");

        $stmt->execute([$name,$address,$phone,$email]);

        echo "success";

    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
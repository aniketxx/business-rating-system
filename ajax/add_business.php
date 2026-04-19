<?php
require "../conn.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name    = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $email   = trim($_POST['email'] ?? '');

    if (empty($name) || empty($email)) {
        echo "Required fields missing";
        exit;
    }

    try {

        $stmt = $conn->prepare("
            INSERT INTO businesses(name,address,phone,email)
            VALUES(?,?,?,?)
        ");

        $stmt->execute([$name,$address,$phone,$email]);

        echo "success";

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}
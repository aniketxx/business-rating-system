<?php
require "../conn.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name    = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $email   = trim($_POST['email'] ?? '');

    if (empty($name) || empty($address) || empty($phone) || empty($email)) {
        echo "Required fields missing";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid Email";
        exit;
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "Invalid Phone";
        exit;
    }

    $check = $conn->prepare("
        SELECT id FROM businesses
        WHERE email = ? OR phone = ?
    ");

    $check->execute([$email,$phone]);

    if ($check->rowCount() > 0) {
        echo "Duplicate";
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
        echo "error";
    }
}
<?php
require __DIR__ . "/../conn.php";

$id      = $_POST['id'];
$name    = trim($_POST['name']);
$address = trim($_POST['address']);
$phone   = trim($_POST['phone']);
$email   = trim($_POST['email']);

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
    WHERE (email = ? OR phone = ?)
    AND id != ?
");

$check->execute([$email,$phone,$id]);

if ($check->rowCount() > 0) {
    echo "Duplicate";
    exit;
}

$stmt = $conn->prepare("
    UPDATE businesses
    SET name = ?,
        address = ?,
        phone = ?,
        email = ?
    WHERE id = ?
");

$stmt->execute([
    $name,
    $address,
    $phone,
    $email,
    $id
]);

echo "success";
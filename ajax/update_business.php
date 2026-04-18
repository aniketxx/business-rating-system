<?php
require __DIR__ . "/../conn.php";

$id      = $_POST['id'];
$name    = $_POST['name'];
$address = $_POST['address'];
$phone   = $_POST['phone'];
$email   = $_POST['email'];

/* UPDATE BUSINESS */
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
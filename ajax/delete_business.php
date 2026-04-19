<?php
require "../conn.php";

$id = $_POST['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM businesses WHERE id=?");
$stmt->execute([$id]);

echo "success";
<?php
require __DIR__ . "/../conn.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM businesses WHERE id=?");
$stmt->execute([$id]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<input type="hidden" name="id" value="<?=$row['id']?>">

<input name="name" class="form-control mb-2"
value="<?=$row['name']?>" required>

<input name="address" class="form-control mb-2"
value="<?=$row['address']?>">

<input name="phone" class="form-control mb-2"
value="<?=$row['phone']?>">

<input name="email" class="form-control mb-2"
value="<?=$row['email']?>">

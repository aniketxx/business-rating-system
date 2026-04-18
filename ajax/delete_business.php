<?php
include "../conn.php";
$conn->query("DELETE FROM businesses WHERE id=".$_POST['id']);
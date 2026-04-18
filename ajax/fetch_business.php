<?php
require_once __DIR__ . "/../conn.php";

$stmt = $conn->query("
SELECT b.*, 
IFNULL(AVG(r.rating),0) as avg_rating
FROM businesses b
LEFT JOIN ratings r ON r.business_id=b.id
GROUP BY b.id
");

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
?>

<tr id="row<?=$row['id']?>">

<td><?=$row['id']?></td>
<td><?=$row['name']?></td>
<td><?=$row['address']?></td>
<td><?=$row['phone']?></td>
<td><?=$row['email']?></td>

<td>
<button class="btn btn-warning editBtn" data-id="<?=$row['id']?>">Edit</button>
<button class="btn btn-danger deleteBtn" data-id="<?=$row['id']?>">Delete</button>
</td>

<td>
<div class="ratingView"
     data-score="<?=$row['avg_rating']?>"
     data-id="<?=$row['id']?>"></div>
</td>

</tr>

<?php } ?>
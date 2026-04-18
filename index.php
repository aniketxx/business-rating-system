<?php include "config/db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="container mt-4">

<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
Add Business
</button>

<table class="table table-bordered mt-3">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Address</th>
<th>Phone</th>
<th>Email</th>
<th>Actions</th>
<th>Average Rating</th>
</tr>
</thead>

<tbody id="businessTable">
</tbody>

</table>
</div>


<!-- add  -->
 <div class="modal fade" id="addModal">
<div class="modal-dialog">
<div class="modal-content">

<form id="addBusinessForm">

<div class="modal-body">

<input name="name" class="form-control mb-2" placeholder="Name" required>
<input name="address" class="form-control mb-2" placeholder="Address">
<input name="phone" class="form-control mb-2" placeholder="Phone">
<input name="email" class="form-control mb-2" placeholder="Email">

</div>

<div class="modal-footer">
<button class="btn btn-success">Save</button>
</div>

</form>

</div>
</div>
</div>

<!-- rating -->
 <div class="modal fade" id="ratingModal">
<div class="modal-dialog">
<div class="modal-content">

<form id="ratingForm">

<div class="modal-body">

<input type="hidden" name="business_id" id="rating_business_id">

<input name="name" class="form-control mb-2" placeholder="Name" required>
<input name="email" class="form-control mb-2" placeholder="Email">
<input name="phone" class="form-control mb-2" placeholder="Phone">

<div id="ratingStars"></div>
<input type="hidden" name="rating" id="ratingValue">

</div>

<div class="modal-footer">
<button class="btn btn-success">Submit Rating</button>
</div>

</form>

</div>
</div>
</div>

<div class="modal fade" id="editModal">
<div class="modal-dialog">
<div class="modal-content">

<form id="editForm">
<div class="modal-body" id="editBody"></div>

<div class="modal-footer">
<button class="btn btn-success">Update</button>
</div>

</form>

</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/jquery.raty.min.js"></script>

<script>
if ($.fn.raty) {
   $.fn.raty.defaults.path =
'https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/images';
}

function loadBusinesses(){

    $("#businessTable").load("ajax/fetch_business.php",function(){

        $('.ratingView').raty({
            readOnly:true,
            half:true,
            score:function(){
                return $(this).data("score");
            }
        });

    });
}

$(document).ready(function(){
    loadBusinesses();
});

/* ADD */
$("#addBusinessForm").submit(function(e){
e.preventDefault();

$.post("ajax/add_business.php",
$(this).serialize(),
function(res){

console.log(res); // 👈 ADD THIS

bootstrap.Modal
.getOrCreateInstance(document.getElementById('addModal'))
.hide();

loadBusinesses();
});
});

/* EDIT OPEN */
$(document).on("click",".editBtn",function(){

$.get("ajax/get_business.php",
{id:$(this).data("id")},
function(data){

$("#editBody").html(data);

bootstrap.Modal
.getOrCreateInstance(document.getElementById('editModal'))
.show();
});
});

/* EDIT SAVE */
$(document).on("submit","#editForm",function(e){
e.preventDefault();

$.post("ajax/update_business.php",
$(this).serialize(),
function(){

bootstrap.Modal
.getOrCreateInstance(document.getElementById('editModal'))
.hide();

loadBusinesses();
});
});

/* DELETE */
$(document).on("click",".deleteBtn",function(){

if(!confirm("Delete business?")) return;

$.post("ajax/delete_business.php",
{id:$(this).data("id")},
loadBusinesses);
});

/* OPEN RATING */
$(document).on("click",".ratingView",function(){

    $("#rating_business_id").val($(this).data("id"));

    $('#ratingStars').raty('destroy');

    $('#ratingStars').raty({
        half:true,
        path:'https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/images',
        click:function(score){
            $("#ratingValue").val(score);
        }
    });

    bootstrap.Modal
    .getOrCreateInstance(document.getElementById('ratingModal'))
    .show();
});

/* SAVE RATING */
$("#ratingForm").submit(function(e){
e.preventDefault();

$.post("ajax/save_rating.php",
$(this).serialize(),
function(){

bootstrap.Modal
.getOrCreateInstance(document.getElementById('ratingModal'))
.hide();

loadBusinesses();
});
});
</script>


</body>
</html>

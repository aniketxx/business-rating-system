<?php include "conn.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Business Listing & Rating System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f8f9fa;
}
.table td, .table th{
    vertical-align:middle;
}
</style>
</head>

<body>

<div class="container mt-5">

<h2 class="mb-4">Business Listing & Rating System</h2>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
Add Business
</button>

<table class="table table-bordered bg-white">
<thead class="table-dark">
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

<tbody id="businessTable"></tbody>
</table>

</div>


<!-- ADD MODAL -->
<div class="modal fade" id="addModal">
<div class="modal-dialog">
<div class="modal-content">

<form id="addBusinessForm">

<div class="modal-header">
<h5>Add Business</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input name="name" class="form-control mb-2" placeholder="Business Name" required>

<input name="address" class="form-control mb-2" placeholder="Address" required>

<input name="phone" class="form-control mb-2" placeholder="Phone" required>

<input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

</div>

<div class="modal-footer">
<button class="btn btn-success">Save</button>
</div>

</form>

</div>
</div>
</div>



<!-- EDIT MODAL -->
<div class="modal fade" id="editModal">
<div class="modal-dialog">
<div class="modal-content">

<form id="editForm">

<div class="modal-header">
<h5>Edit Business</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body" id="editBody"></div>

<div class="modal-footer">
<button class="btn btn-primary">Update</button>
</div>

</form>

</div>
</div>
</div>



<!-- RATING MODAL -->
<div class="modal fade" id="ratingModal">
<div class="modal-dialog">
<div class="modal-content">

<form id="ratingForm">

<div class="modal-header">
<h5>Submit Rating</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<input type="hidden" name="business_id" id="rating_business_id">

<input name="name" class="form-control mb-2" placeholder="Your Name" required>

<input type="email" name="email" class="form-control mb-2" placeholder="Email">

<input name="phone" class="form-control mb-2" placeholder="Phone">

<div id="ratingStars" class="mb-2"></div>

<input type="hidden" name="rating" id="ratingValue">

</div>

<div class="modal-footer">
<button class="btn btn-success">Submit Rating</button>
</div>

</form>

</div>
</div>
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/jquery.raty.min.js"></script>


<script>

if($.fn.raty){
    $.fn.raty.defaults.path =
    'https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/images';
}


// EMAIL VALIDATION
function validateEmail(email){
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}


function loadBusinesses(){

    $("#businessTable").load("ajax/fetch_business.php", function(){

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


$("#addBusinessForm").submit(function(e){

e.preventDefault();

let email = $("input[name='email']", this).val();

if(!validateEmail(email)){
    alert("Invalid Email");
    return;
}

$.post("ajax/add_business.php",
$(this).serialize(),
function(res){

bootstrap.Modal
.getOrCreateInstance(document.getElementById('addModal'))
.hide();

$("#addBusinessForm")[0].reset();

loadBusinesses();

});

});


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


$(document).on("click",".deleteBtn",function(){

if(!confirm("Delete this business?")) return;

$.post("ajax/delete_business.php",
{id:$(this).data("id")},
function(){
loadBusinesses();
});

});


$(document).on("click",".ratingView",function(){

$("#rating_business_id").val($(this).data("id"));

$('#ratingStars').raty('destroy');

$('#ratingStars').raty({
    half:true,
    click:function(score){
        $("#ratingValue").val(score);
    }
});

bootstrap.Modal
.getOrCreateInstance(document.getElementById('ratingModal'))
.show();

});


$("#ratingForm").submit(function(e){

e.preventDefault();

let email = $("input[name='email']", this).val();
let phone = $("input[name='phone']", this).val();
let rating = $("#ratingValue").val();

if(email=="" && phone==""){
    alert("Email OR Phone required");
    return;
}

if(rating==""){
    alert("Please select rating");
    return;
}

$.post("ajax/save_rating.php",
$(this).serialize(),
function(){

bootstrap.Modal
.getOrCreateInstance(document.getElementById('ratingModal'))
.hide();

$("#ratingForm")[0].reset();

loadBusinesses();

});

});

</script>

</body>
</html>
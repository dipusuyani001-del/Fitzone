<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location:index.php");
    exit();
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM diet_plans WHERE id='$id'");
    header("Location:view_diet.php");
}

$q = mysqli_query($conn,"
SELECT d.*, m.name 
FROM diet_plans d
JOIN members m ON d.member_id = m.id
ORDER BY d.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Diet Plans</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#243b55;
    margin:0;
    overflow-x:hidden;
}

.card{
    border-radius:15px; 
    animation:fadeIn .5s ease;
}

@keyframes fadeIn{
from{opacity:0; transform:scale(.95)}
to{opacity:1; transform:scale(1)}
}

/* ===== MOBILE RESPONSIVE IMPROVEMENTS ===== */
@media(max-width:768px){

    .container{
        padding-left:10px;
        padding-right:10px;
    }

    h4{
        font-size:18px;
    }

    .navbar-brand{
        font-size:16px;
    }

    table{
        font-size:13px;
    }

    .btn-sm{
        padding:4px 8px;
        font-size:12px;
    }
}
</style>
</head>

<body>

<nav class="navbar bg-dark navbar-dark px-3 px-md-4">
<span class="navbar-brand">🥗 Diet Plans</span>
<a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="container mt-4 mt-md-5">

<div class="card shadow-lg">
<div class="card-body">

<h4 class="text-center mb-4">All Diet Plans</h4>

<div class="table-responsive">
<table class="table table-hover align-middle">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Member</th>
<th>Title</th>
<th>Calories</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($r=mysqli_fetch_assoc($q)){ ?>
<tr>
<td><?= $r['id'] ?></td>
<td><?= $r['name'] ?></td>
<td><?= $r['plan_title'] ?></td>
<td><?= $r['calories'] ?></td>
<td><?= $r['created_at'] ?></td>
<td>
<a href="edit_diet.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
<a href="view_diet.php?delete=<?= $r['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
</td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

</div>
</div>

</div>

</body>
</html>
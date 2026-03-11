<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location:index.php");
    exit();
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM diet_plans WHERE id='$id'
"));

$msg="";

if(isset($_POST['update'])){

$member_id = $_POST['member_id'];
$title     = $_POST['plan_title'];
$desc      = $_POST['description'];
$calories  = $_POST['calories'];

mysqli_query($conn,"UPDATE diet_plans SET
member_id='$member_id',
plan_title='$title',
description='$desc',
calories='$calories'
WHERE id='$id'");

$msg="Diet Plan Updated Successfully ✅";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Diet Plan</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#243b55;
    min-height:100vh;
    margin:0;
    overflow-x:hidden;
}

/* ===== CENTER WRAPPER ===== */
.main-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:calc(100vh - 56px);
    padding:15px;
}

/* ===== CARD STYLE ===== */
.card{
    border-radius:15px; 
    animation:fadeIn .5s ease;
    width:100%;
    max-width:550px;
}

@keyframes fadeIn{
from{opacity:0; transform:scale(.95)}
to{opacity:1; transform:scale(1)}
}

/* ===== MOBILE OPTIMIZATION ===== */
@media(max-width:576px){

    .main-wrapper{
        padding:10px;
    }

    .card{
        max-width:100%;
    }

    h4{
        font-size:18px;
    }

    .navbar-brand{
        font-size:16px;
    }

    textarea{
        font-size:14px;
    }
}
</style>
</head>

<body>

<nav class="navbar bg-dark navbar-dark px-4">
<span class="navbar-brand">✏️ Edit Diet Plan</span>
<a href="view_diet.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="main-wrapper">

<div class="card shadow-lg">
<div class="card-body">

<h4 class="text-center mb-4">Update Diet Plan</h4>

<?php if($msg!=""){ ?>
<div class="alert alert-success text-center"><?= $msg ?></div>
<?php } ?>

<form method="post">

<select name="member_id" class="form-control mb-3" required>
<?php
$m = mysqli_query($conn,"SELECT id,name FROM members");
while($row=mysqli_fetch_assoc($m)){
$selected = ($row['id']==$data['member_id'])?"selected":"";
echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
}
?>
</select>

<input type="text" name="plan_title" class="form-control mb-3" value="<?= $data['plan_title'] ?>" required>

<textarea name="description" class="form-control mb-3" rows="4" required><?= $data['description'] ?></textarea>

<input type="text" name="calories" class="form-control mb-3" value="<?= $data['calories'] ?>">

<button name="update" class="btn btn-primary w-100">Update Plan</button>

</form>

</div>
</div>

</div>

</body>
</html>
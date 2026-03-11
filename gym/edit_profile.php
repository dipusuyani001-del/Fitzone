<?php
session_start();
include 'db.php';

if(!isset($_SESSION['member_id'])){
    header("Location:index.php");
    exit();
}

$mid = $_SESSION['member_id'];

if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    mysqli_query($conn,"UPDATE members 
                        SET name='$name',
                            email='$email',
                            phone='$phone'
                        WHERE id='$mid'");

    header("Location:member_profile.php");
    exit();
}

$q = mysqli_query($conn,"SELECT name,email,phone FROM members WHERE id='$mid'");
$member = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:linear-gradient(135deg,#0f2027,#203a43,#2c5364);">

<nav class="navbar bg-dark navbar-dark px-4">
    <span class="navbar-brand">✏ Edit Profile</span>
    <a href="member_dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height:85vh;">

<div class="card shadow-lg p-4" style="max-width:500px;width:100%;border-radius:15px;">

<h4 class="text-center mb-3">Update Your Details</h4>

<form method="POST">

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" value="<?= htmlspecialchars($member['name']) ?>" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" value="<?= htmlspecialchars($member['email']) ?>" class="form-control" required>
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" value="<?= htmlspecialchars($member['phone']) ?>" class="form-control" required>
</div>

<button type="submit" name="update" class="btn btn-success w-100">
    ✅ Update Profile
</button>

</form>

</div>
</div>
</body>
</html>

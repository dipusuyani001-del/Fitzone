<?php
session_start();
include 'db.php';

if(!isset($_SESSION['member_id'])){
    header("Location:index.php");
    exit();
}

$mid = $_SESSION['member_id'];

$q = mysqli_query($conn,
    "SELECT name,email,phone 
     FROM members 
     WHERE id='$mid'"
);

$member = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    font-family: Arial, sans-serif;
}

/* Profile Card */
.profile-box{
    background:#ffffff;
    max-width:450px;
    border-radius:15px;
    padding:30px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

/* Profile Header */
.profile-header{
    background:#2a5298;
    color:white;
    padding:20px;
    border-radius:15px 15px 0 0;
}

/* Info Row */
.info-row{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    border-bottom:1px solid #eee;
}

.info-row:last-child{
    border-bottom:none;
}

.label{
    font-weight:600;
    color:#555;
}

.value{
    font-weight:500;
    color:#000;
}

.btn-custom{
    border-radius:25px;
    font-weight:600;
}
</style>

</head>

<body>

<nav class="navbar navbar-dark bg-primary px-4 shadow">
    <span class="navbar-brand fw-bold">👤 My Profile</span>
    <a href="member_dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height:85vh;">

    <div class="profile-box">

        <!-- Profile Header -->
        <div class="profile-header text-center">
            <h4 class="mb-1"><?= htmlspecialchars($member['name']) ?></h4>
            <small>Gym Member</small>
        </div>

        <!-- Profile Body -->
        <div class="mt-4">

            <div class="info-row">
                <span class="label">Name :</span>
                <span class="value"><?= htmlspecialchars($member['name']) ?></span>
            </div>

            <div class="info-row">
                <span class="label">Email :</span>
                <span class="value"><?= htmlspecialchars($member['email']) ?></span>
            </div>

            <div class="info-row">
                <span class="label">Phone Number :</span>
                <span class="value"><?= htmlspecialchars($member['phone']) ?></span>
            </div>

            <a href="change_password.php" class="btn btn-warning w-100 mt-4 btn-custom">
                🔒 Change Password
            </a>

        </div>

    </div>

</div>

</body>
</html>

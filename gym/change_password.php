<?php
session_start();
include 'db.php';

if(!isset($_SESSION['member_id'])){
    header("Location:index.php");
    exit();
}

$msg = "";

if(isset($_POST['change'])){
    $old = $_POST['old'];
    $new = $_POST['new'];
    $cnew = $_POST['cnew'];

    $mid = $_SESSION['member_id'];

    $q = mysqli_query($conn,
        "SELECT password FROM members WHERE id='$mid'"
    );
    $row = mysqli_fetch_assoc($q);

    if($row['password'] != $old){
        $msg = "❌ Old password incorrect";
    }
    elseif($new != $cnew){
        $msg = "❌ New passwords do not match";
    }
    else{
        mysqli_query($conn,
            "UPDATE members SET password='$new' WHERE id='$mid'"
        );
        $msg = "✅ Password changed successfully";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>
body{
    margin:0;
    min-height:100vh;
    display:flex;
    flex-direction:column;
}

/* Center Wrapper */
.main-wrapper{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Keep original card design */
.member-card{
    width:100%;
    max-width:450px;
}
</style>

</head>

<body class="dashboard-page">

<nav class="navbar bg-warning navbar-dark px-4">
    <span class="navbar-brand">🔒 Change Password</span>
    <a href="member_dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="main-wrapper">
    <div class="member-card">
        <h3>Change Password</h3>

        <?php if($msg!=""){ ?>
            <div class="alert alert-info"><?= $msg ?></div>
        <?php } ?>

        <form method="post">
            <input type="password" name="old" class="form-control mb-3" placeholder="Old Password" required>
            <input type="password" name="new" class="form-control mb-3" placeholder="New Password" required>
            <input type="password" name="cnew" class="form-control mb-3" placeholder="Confirm New Password" required>

            <button name="change" class="btn btn-warning w-100">
                Update Password
            </button>
        </form>
    </div>
</div>

</body>
</html>
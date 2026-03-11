<?php
include 'db.php';

if(isset($_POST['reset'])){
    $email = $_POST['email'];
    $new   = $_POST['new'];

    $q = mysqli_query($conn,
        "SELECT * FROM members WHERE email='$email'"
    );

    if(mysqli_num_rows($q)==1){
        mysqli_query($conn,
            "UPDATE members SET password='$new' WHERE email='$email'"
        );
        $msg = "Password Reset Successfully";
    } else {
        $err = "Email not found";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="login-page">

<div class="login-wrapper">
<div class="login-box">

<h3 class="text-center">🔐 Forgot Password</h3>

<?php
if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>";
if(isset($err)) echo "<div class='alert alert-danger'>$err</div>";
?>

<form method="post">
    <input type="email" name="email" class="form-control mb-3" placeholder="Registered Email" required>
    <input type="password" name="new" class="form-control mb-3" placeholder="New Password" required>

    <button name="reset" class="btn btn-login text-white w-100">
        Reset Password
    </button>
</form>

<div class="text-center mt-3">
    <a href="index.php">Back to Login</a>
</div>

</div>
</div>

</body>
</html>

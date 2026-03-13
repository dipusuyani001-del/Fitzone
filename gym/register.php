<?php
include 'db.php';

$msg="";

if(isset($_POST['register'])){

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

if($name=="" || $email=="" || $password==""){
$msg="❌ All fields are required";
}
else{

mysqli_query($conn,"INSERT INTO members(name,email,password)
VALUES('$name','$email','$password')");

$msg="✅ Registration Successful";

}

}
?>

<!DOCTYPE html>
<html>
<head>

<title>User Register</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#243b55;
min-height:100vh;
display:flex;
flex-direction:column;
font-family:'Segoe UI', sans-serif;
}

/* Center wrapper */
.main-wrapper{
flex:1;
display:flex;
justify-content:center;
align-items:center;
padding:20px;
}

/* Register card */
.register-card{
background:white;
width:100%;
max-width:420px;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.3);
overflow:hidden;
}

/* Header */
.register-header{
background:#212529;
color:white;
padding:18px;
text-align:center;
font-weight:600;
font-size:18px;
}

/* Body */
.register-body{
padding:25px;
}

.form-control{
border-radius:10px;
padding:10px;
}

.btn-register{
background:#198754;
color:white;
font-weight:600;
border-radius:10px;
padding:10px;
}

.btn-register:hover{
background:#42a1f5;
}

</style>

</head>

<body>

<nav class="navbar bg-dark navbar-dark px-4">
<span class="navbar-brand">🏋️ Gym Registration</span>
<a href="index.php" class="btn btn-light btn-sm">Login</a>
</nav>

<div class="main-wrapper">

<div class="register-card">

<div class="register-header">
Create New Account
</div>

<div class="register-body">

<?php if($msg!=""){ ?>
<div class="alert alert-info text-center">
<?= $msg ?>
</div>
<?php } ?>

<form method="post">

<div class="mb-3">
<label class="form-label">Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<button name="register" class="btn btn-register w-100">
Register
</button>

</form>

</div>

</div>

</div>

</body>
</html>
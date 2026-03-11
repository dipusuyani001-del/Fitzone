<?php 
session_start();
include 'db.php';

if(isset($_POST['login'])){

    $u = trim($_POST['u']);
    $p = trim($_POST['p']);

    /* ---------- ADMIN LOGIN ---------- */
    if($u == "admin" && $p == "admin123"){
        $_SESSION['admin'] = "admin";
        header("Location: dashboard.php");
        exit();
    }

    /* ---------- MEMBER LOGIN ---------- */
    $q = mysqli_query($conn,
        "SELECT * FROM members 
         WHERE email='$u' AND password='$p'"
    );

    if(mysqli_num_rows($q) === 1){
        $row = mysqli_fetch_assoc($q);

        $_SESSION['member_id']   = $row['id'];
        $_SESSION['member_name'] = $row['name'];

        header("Location: member_dashboard.php");
        exit();
    }

    $error = "Invalid Username or Password";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gym Login</title>

    <!-- IMPORTANT FOR MOBILE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    padding:0;
    min-height:100vh;
    background: linear-gradient(135deg,#0f2027,#203a43,#2c5364);
    display:flex;
    justify-content:center;
    align-items:center;
    font-family: 'Segoe UI', sans-serif;
}

.login-box{
    background: rgba(255,255,255,0.3);
    backdrop-filter: blur(15px);
    padding:40px 30px;
    border-radius:20px;
    width:100%;
    max-width:400px;
    color:white;
    box-shadow:0 15px 35px rgba(0,0,0,0.3);
}

.login-box h3{
    font-weight:600;
}

.form-control{
    border-radius:10px;
    padding:12px;
}

.btn-login{
    background:#00c6ff;
    border:none;
    padding:12px;
    border-radius:10px;
    font-weight:600;
    transition:0.3s;
}

.btn-login:hover{
    background:#0072ff;
    transform:scale(1.02);
}

.forgot-link{
    color:#ddd;
    text-decoration:none;
    font-size:14px;
}

.forgot-link:hover{
    color:#fff;
    text-decoration:underline;
}

/* Mobile spacing */
@media(max-width:576px){
    .login-box{
        padding:30px 20px;
    }
}
</style>

</head>

<body>

<div class="login-box">

    <h3 class="text-center mb-4">🏋️ Gym Login</h3>

    <?php if(isset($error)){ ?>
        <div class="alert alert-danger text-center p-2">
            <?= $error ?>
        </div>
    <?php } ?>

    <form method="post">

        <input 
            type="text" 
            name="u"
            class="form-control mb-3" 
            placeholder="Email"
            required
        >

        <input 
            type="password" 
            name="p" 
            class="form-control mb-2" 
            placeholder="Password"
            required
        >

        <div class="text-end mb-3">
            <a href="member_forget_password.php" class="forgot-link">
                Forgot Password?
            </a>
        </div>

        <button name="login" class="btn btn-login w-100">
            Login
        </button>

    </form>
</div>

</body>
</html>

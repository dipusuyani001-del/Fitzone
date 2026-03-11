<?php 
include 'db.php';

$error = "";
$success = "";

if(isset($_POST['add'])){   

    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = $_POST['password'];

    /* ✅ PHONE: only numbers + exactly 10 digits */
    if(!preg_match("/^[0-9]{10}$/", $phone)){
        $error = "Phone number must be exactly 10 digits (numbers only)";
    }
    /* ✅ EMAIL: must be valid + must end with .com */
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/\.com$/", $email)){
        $error = "Email must be valid and end with .com";
    }
    else{
        mysqli_query($conn,"INSERT INTO members(name,email,phone,password)
        VALUES('$name','$email','$phone','$password')");
        $success = "Member added successfully";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>

    <!-- ✅ Mobile Responsive Important -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <style>
        /* Disable horizontal scroll */
        html, body{
            overflow-x:hidden;
        }

        body.dashboard-page{
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }

        /* Center wrapper */
        .main-wrapper{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px 10px;
        }

        /* Card styling */
        .member-card{
            width:100%;
            max-width:450px;
            background:#fff;
            padding:30px;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }

        .member-card h3{
            text-align:center;
            margin-bottom:25px;
        }

        /* Mobile adjustments */
        @media(max-width:576px){

            .member-card{
                padding:20px;
            }

            .member-card h3{
                font-size:20px;
            }

            .form-control{
                font-size:14px;
            }

            .btn{
                font-size:14px;
            }
        }
    </style>
</head>

<body class="dashboard-page">

<!-- NAVBAR -->
<nav class="navbar bg-dark navbar-dark px-3 px-md-4 shadow">
    <span class="navbar-brand fw-bold">➕ Add Member</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<!-- ✅ CENTERED FORM -->
<div class="main-wrapper">
    <div class="member-card">

        <h3>Add Member</h3>

        <?php if($error!=""){ ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php } ?>

        <?php if($success!=""){ ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php } ?>

        <form method="post">
            <input name="name" class="form-control mb-3" placeholder="Full Name" required>
            <input name="email" class="form-control mb-3" placeholder="Email" required>
            <input name="phone" class="form-control mb-3" placeholder="Phone" required>
            <input name="password" class="form-control mb-3" placeholder="Password" required>
            <button name="add" class="btn btn-primary w-100">
                Save Member
            </button>
        </form>

    </div>
</div>

</body>
</html>
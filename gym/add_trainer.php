<?php 
include 'db.php';

$error = "";
$success = "";

if(isset($_POST['add'])){
    $name  = $_POST['name'];
    $phone = $_POST['phone'];

    // ✅ PHP validation: exactly 10 digits
    if(!preg_match('/^[0-9]{10}$/', $phone)){
        $error = "❌ Invalid phone number (Enter exactly 10 digits)";
    } else {
        mysqli_query($conn,
            "INSERT INTO trainers(name,phone) VALUES('$name','$phone')"
        );
        $success = "✅ Trainer added successfully";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Trainer</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <style>
        body{
            background:#243b55;
            overflow-x:hidden;
            min-height:100vh;
        }

        /* ===== CENTER FIX ===== */
        .main-wrapper{
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:calc(100vh - 56px); /* navbar height adjust */
            padding:20px;
        }

        .trainer-card{
            width:100%;
            max-width:420px;
            background:#fff;
            padding:25px;
            border-radius:12px;
            box-shadow:0 8px 25px rgba(0,0,0,0.25);
            animation:fadeIn 0.5s ease;
        }

        @keyframes fadeIn{
            from{opacity:0; transform:translateY(20px)}
            to{opacity:1; transform:translateY(0)}
        }

        @media(max-width:576px){
            .trainer-card{
                padding:20px 15px;
            }

            .navbar-brand{
                font-size:16px;
            }
        }
    </style>
</head>

<body class="dashboard-page">

<nav class="navbar bg-dark navbar-dark px-3 px-md-4 shadow d-flex justify-content-between">
    <span class="navbar-brand fw-bold">➕ Add Trainer</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<!-- CENTERED WRAPPER -->
<div class="main-wrapper">
    <div class="trainer-card">

        <h3 class="text-center mb-4">Add Trainer</h3>

        <?php if($error!=""): ?>
            <div class="alert alert-danger text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if($success!=""): ?>
            <div class="alert alert-success text-center">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form method="post">

            <input 
                name="name" 
                class="form-control mb-3" 
                placeholder="Trainer Name" 
                required
            >

            <input 
                name="phone" 
                class="form-control mb-3" 
                placeholder="Phone Number (10 digits)"
                pattern="[0-9]{10}"
                maxlength="10"
                inputmode="numeric"
                required
            >

            <button name="add" class="btn btn-success w-100">
                Save Trainer
            </button>

        </form>

    </div>
</div>

</body>
</html>
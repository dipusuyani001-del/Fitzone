<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location:index.php");
    exit();
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM trainers WHERE id='$id'")
);

if(isset($_POST['update'])){
    $name  = $_POST['name'];
    $phone = $_POST['phone'];

    mysqli_query($conn,"UPDATE trainers SET 
        name='$name',
        phone='$phone'
        WHERE id='$id'
    ");

    header("Location:view_trainer.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Trainer</title>

    <!-- IMPORTANT MOBILE META -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#243b55;
            min-height:100vh;
            display:flex;
            flex-direction:column;
            overflow-x:hidden;
        }

        .edit-wrapper{
            flex:1;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px 15px;
        }

        .card{
            width:100%;
            max-width:420px;
            border-radius:15px;
            animation:fadeIn 0.5s ease;
        }

        @keyframes fadeIn{
            from{opacity:0; transform:scale(0.95)}
            to{opacity:1; transform:scale(1)}
        }

        /* Mobile Optimization */
        @media(max-width:576px){

            .navbar-brand{
                font-size:16px;
            }

            .card{
                max-width:100%;
            }

            .card-body{
                padding:20px 15px;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar bg-dark navbar-dark px-3 px-md-4 d-flex justify-content-between">
    <span class="navbar-brand">✏️ Edit Trainer</span>
    <a href="view_trainer.php" class="btn btn-light btn-sm">Back</a>
</nav>

<!-- CENTERED EDIT CARD -->
<div class="edit-wrapper">
    <div class="card shadow-lg">
        <div class="card-body">

            <h4 class="text-center mb-4 fw-bold">Update Trainer</h4>

            <form method="POST">

                <input 
                    type="text" 
                    name="name" 
                    class="form-control mb-3" 
                    value="<?= $data['name'] ?>" 
                    placeholder="Trainer Name"
                    required
                >

                <input 
                    type="text" 
                    name="phone" 
                    class="form-control mb-3" 
                    value="<?= $data['phone'] ?>" 
                    placeholder="Phone Number"
                    inputmode="numeric"
                    maxlength="10"
                    required
                >

                <button name="update" class="btn btn-primary w-100">
                    Update Trainer
                </button>

            </form>

        </div>
    </div>
</div>

</body>
</html>

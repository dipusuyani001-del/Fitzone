<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location:index.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM trainers ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Trainers</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <style>
        body{
            background:#243b55;
            overflow-x:hidden;
            min-height:100vh;
            margin:0;
        }

        /* ===== CENTER FIX ===== */
        .main-wrapper{
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:calc(100vh - 56px); /* navbar height adjust */
            padding:20px;
        }

        .card{
            border-radius:15px;
            animation: fadeIn 0.6s ease;
            width:100%;
            max-width:900px;
        }

        @keyframes fadeIn{
            from{opacity:0; transform:translateY(20px)}
            to{opacity:1; transform:translateY(0)}
        }

        table th{
            background:#0d6efd;
            color:#fff;
            white-space:nowrap;
        }

        .btn-action{
            transition:0.3s;
            margin:2px;
        }

        .btn-action:hover{
            transform:scale(1.05);
        }

        @media(max-width:576px){

            .navbar-brand{
                font-size:16px;
            }

            table{
                font-size:13px;
            }

            .btn-sm{
                padding:4px 8px;
                font-size:12px;
            }

            th, td{
                padding:8px !important;
            }
        }
    </style>
</head>

<body>

<nav class="navbar bg-dark navbar-dark px-3 px-md-4 d-flex justify-content-between">
    <span class="navbar-brand">👨‍🏫 Trainers List</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<!-- CENTERED WRAPPER -->
<div class="main-wrapper">
    <div class="card shadow-lg">
        <div class="card-body">

            <h4 class="text-center mb-4 fw-bold">👨‍🏫 All Trainers</h4>

            <div class="table-responsive">
                <table class="table table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(mysqli_num_rows($result)>0):
                        $i = 1;
                        while($row = mysqli_fetch_assoc($result)):
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td>
                                <a href="edit_trainer.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-warning btn-sm btn-action">
                                   edit
                                </a>

                                <a href="delete_trainer.php?id=<?= $row['id'] ?>" 
                                   onclick="return confirm('Delete this trainer?')"
                                   class="btn btn-danger btn-sm btn-action">
                                   delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr>
                            <td colspan="4">No trainers found</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
</html>
<?php 
session_start(); 
if(!isset($_SESSION['admin'])) {
    header("Location:index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym Admin Dashboard</title>

    <!-- Responsive Fix -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <style>

    /* Prevent horizontal scroll */
    body{
        overflow-x:hidden;
    }

    /* Dashboard spacing */
    .dashboard-area{
        padding:40px 15px;
    }

    /* Dashboard button styling */
    .dash-btn{
        display:block;
        padding:25px 15px;
        border-radius:15px;
        text-decoration:none;
        color:white;
        text-align:center;
        min-height:130px;
        transition:0.3s;
    }

    .dash-btn h5{
        font-size:18px;
        font-weight:600;
        margin-bottom:5px;
    }

    .dash-btn p{
        font-size:14px;
        margin:0;
        opacity:0.9;
    }

    /* Hover effect */
    .dash-btn:hover{
        transform:translateY(-5px);
        box-shadow:0 8px 20px rgba(0,0,0,0.3);
    }

    /* Navbar responsive */
    .navbar-brand{
        font-size:18px;
    }

    /* Mobile adjustments */
    @media (max-width:576px){

        .navbar-brand{
            font-size:14px;
            line-height:1.2;
        }

        .dash-btn{
            min-height:110px;
            padding:20px 10px;
        }

        .dash-btn h5{
            font-size:15px;
        }

        .dash-btn p{
            font-size:12px;
        }

        .dashboard-area{
            padding:25px 10px;
        }
    }

    </style>

</head>

<body class="dashboard-page">

<nav class="navbar bg-dark navbar-dark px-3 px-md-4 shadow d-flex justify-content-between">
    <span class="navbar-brand fw-bold text-wrap">
        🏋️ Gym Management System Admin Panel
    </span>
    <a href="logout.php" class="btn btn-danger btn-sm">
        Logout
    </a>
</nav>

<div class="container dashboard-area">

    <div class="text-center mb-4 mb-md-5">
        <h2 class="text-white fw-bold">Welcome Admin 👋</h2>
        <p class="text-light opacity-75">Manage your gym easily</p>
    </div>

    <div class="row g-4 justify-content-center">

        <div class="col-6 col-md-4">
            <a href="add_trainer.php" class="dash-btn bg-success">
                <h5>Add Trainer</h5>
                <p>Create new trainer</p>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="view_trainer.php" class="dash-btn bg-secondary">
                <h5>View Trainer</h5>
                <p>All trainers list</p>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="add_member.php" class="dash-btn bg-primary">
                <h5>Add Member</h5>
                <p>Register gym member</p>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="view_members.php" class="dash-btn bg-info">
                <h5>View Members</h5>
                <p>All gym members</p>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="payment.php" class="dash-btn bg-warning text-dark">
                <h5>Payments</h5>
                <p>Payment records</p>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="member_plan.php" class="dash-btn bg-secondary">
                <h5>Membership Plan</h5>
                <p>Assign / View Plans</p>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="add_diet.php" class="dash-btn bg-danger">
                <h5>Add Diet Plan</h5>
                <p>Create new diet plan</p>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="view_diet.php" class="dash-btn bg-dark">
                <h5>View Diet Plans</h5>
                <p>See all diet records</p>
            </a>
        </div>

        <div class="col-6 col-md-4">
            <a href="vip_members.php" class="dash-btn bg-warning">
                <h5>VIP Members</h5>
                <p>Manage and See VIP Members</p>
            </a>
        </div>

    </div>

</div>

</body>
</html>

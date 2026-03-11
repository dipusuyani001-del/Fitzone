<?php
session_start();
if(!isset($_SESSION['member_id'])){
    header("Location:index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Member Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>

<body class="dashboard-page">

<!-- ✅ NAVBAR WITH EDIT ICON -->
<nav class="navbar bg-primary navbar-dark px-4 d-flex justify-content-between">
    
    <span class="navbar-brand">👤 Member Panel</span>

    <div>
        <!-- Edit Profile Icon -->
        <a href="edit_profile.php" class="btn btn-light btn-sm me-2">
            <i class="bi bi-pencil-square">Edit Profile</i>
        </a>

        <!-- Logout Button -->
        <a href="logout.php" class="btn btn-danger btn-sm">
            Logout
        </a>
    </div>

</nav>

<div class="container dashboard-area text-center mt-5">
    
    <h2 class="text-white">Welcome <?= $_SESSION['member_name'] ?></h2>
    <p class="text-light">Your Gym Dashboard</p>

    <div class="row justify-content-center mt-4">

        <div class="col-md-3 mb-3">
            <a class="dash-btn bg-info text-white text-decoration-none d-block p-4 rounded shadow" href="member_profile.php">
                <i class="bi bi-person-circle fs-2"></i>
                <h5 class="mt-2">My Profile</h5>
                <p>View Details</p>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a class="dash-btn bg-warning text-dark text-decoration-none d-block p-4 rounded shadow" href="payment_history.php">
                <i class="bi bi-credit-card fs-2"></i>
                <h5 class="mt-2">Payments</h5>
                <p>My Payment History</p>
            </a>
        </div>

        <div class="col-md-3 mb-3">
            <a class="dash-btn bg-success text-white text-decoration-none d-block p-4 rounded shadow" href="weekly_plan.php">
                <i class="bi bi-calendar-week fs-2"></i>
                <h5 class="mt-2">Workout Plan</h5>
                <p>View Weekly Schedule</p>
            </a>
        </div>

    </div>

</div>

</body>
</html>

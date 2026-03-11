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
    <title>Weekly Workout Plan</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#1e3c72,#2a5298);
        }

        .workout-box{
            max-width: 500px;   /* 👈 Box chhota kiya */
            width: 100%;
            border-radius: 15px;
        }
    </style>
</head>

<body>

<nav class="navbar bg-primary navbar-dark px-4 shadow">
    <span class="navbar-brand">🏋️ Weekly Workout Plan</span>
    <a href="member_dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="container d-flex justify-content-center align-items-center" style="min-height:85vh;">

    <div class="card workout-box shadow-lg p-3 bg-white">

        <h4 class="text-center mb-3">Weekly Workout Schedule</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Day</th>
                        <th>Workout</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Monday</td><td>Chest + Triceps</td></tr>
                    <tr><td>Tuesday</td><td>Back + Biceps</td></tr>
                    <tr><td>Wednesday</td><td>Cardio + Abs</td></tr>
                    <tr><td>Thursday</td><td>Legs + Shoulders</td></tr>
                    <tr><td>Friday</td><td>Full Body Circuit</td></tr>
                    <tr><td>Saturday</td><td>Yoga / Stretching</td></tr>
                    <tr><td>Sunday</td><td>Rest Day</td></tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>

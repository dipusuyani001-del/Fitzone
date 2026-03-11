<?php
session_start();
$conn = mysqli_connect("localhost","root","","gym_db");

if(!isset($_SESSION['admin'])){
    header("Location:index.php");
    exit();
}

/* ---------- DELETE LOGIC ---------- */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM member_plans WHERE id='$id'");
    header("Location:member_plan.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Member Plans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        .action-btns a{
            margin: 0 3px;
            transition: 0.3s;
        }
        .action-btns a:hover{
            transform: scale(1.1);
        }
    </style>
</head>

<body class="dashboard-page">

<nav class="navbar bg-dark navbar-dark px-4 shadow">
    <span class="navbar-brand fw-bold">📋 Member Membership Plans</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="container mt-5 view-card">

    <h3 class="text-center mb-4">📋 Assigned Membership Plans</h3>

    <div class="table-responsive">
        <table class="table table-hover member-table text-center align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Duration</th>
                    <th>Amount</th>
                    <th>Assign Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $q = mysqli_query($conn,"
                SELECT 
                    member_plans.id AS mp_id,
                    members.name AS member_name,
                    membership_assign_plans.plan_name,
                    membership_assign_plans.months,
                    membership_assign_plans.amount,
                    member_plans.assign_date,
                    DATE_ADD(member_plans.assign_date,
                        INTERVAL membership_assign_plans.months MONTH) AS expiry_date
                FROM member_plans
                INNER JOIN members ON member_plans.member_id = members.id
                INNER JOIN membership_assign_plans ON member_plans.plan_id = membership_assign_plans.id
                ORDER BY member_plans.id DESC
            ");

            $i = 1;
            $today = date("Y-m-d");

            while($row = mysqli_fetch_assoc($q)){
                $status = ($row['expiry_date'] >= $today)
                    ? "<span class='badge bg-success'>Active</span>"
                    : "<span class='badge bg-danger'>Expired</span>";
            ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['member_name'] ?></td>
                    <td><?= $row['plan_name'] ?></td>
                    <td><?= $row['months'] ?> Months</td>
                    <td>₹<?= $row['amount'] ?></td>
                    <td><?= date("d M Y", strtotime($row['assign_date'])) ?></td>
                    <td><?= date("d M Y", strtotime($row['expiry_date'])) ?></td>
                    <td><?= $status ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>

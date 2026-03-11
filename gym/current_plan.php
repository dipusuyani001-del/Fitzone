<?php
session_start();
include 'db.php';

if(!isset($_SESSION['member_id'])){
    header("Location:index.php");
    exit();
}

$member_id = $_SESSION['member_id'];

// Fetch current membership plan
$current_plan_query = mysqli_query($conn, "
    SELECT mp.id AS mp_id, mp.assign_date, p.plan_name, p.months, p.amount,
           DATE_ADD(mp.assign_date, INTERVAL p.months MONTH) AS expiry_date
    FROM member_plans mp
    INNER JOIN membership_assign_plans p ON mp.plan_id = p.id
    WHERE mp.member_id='$member_id'
    ORDER BY mp.assign_date DESC
    LIMIT 1
");
$current_plan = mysqli_fetch_assoc($current_plan_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Current Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #f0f2f5; }
        .plan-card { max-width: 500px; margin: 80px auto; padding: 30px; border-radius: 15px; background: #fff; box-shadow: 0 10px 25px rgba(0,0,0,0.15); text-align: center; }
        .plan-card h3 { color: #0d6efd; margin-bottom: 20px; }
        .plan-card p { font-size: 1.1rem; margin: 5px 0; }
        .btn-back { margin-top: 20px; }
    </style>
</head>
<body>

<div class="plan-card">
    <h3>🏋️ Current Membership Plan</h3>

    <?php if($current_plan): ?>
        <p><strong>Plan Name:</strong> <?= $current_plan['plan_name'] ?></p>
        <p><strong>Duration:</strong> <?= $current_plan['months'] ?> Months</p>
        <p><strong>Amount:</strong> ₹<?= $current_plan['amount'] ?></p>
        <p><strong>Assigned On:</strong> <?= date("d M Y", strtotime($current_plan['assign_date'])) ?></p>
        <p><strong>Expiry Date:</strong> <?= date("d M Y", strtotime($current_plan['expiry_date'])) ?></p>
    <?php else: ?>
        <p class="text-danger">You do not have any active membership plan yet.</p>
    <?php endif; ?>

    <a href="payment_history.php" class="btn btn-primary btn-back">💳 Make Payment</a>
</div>

</body>
</html>

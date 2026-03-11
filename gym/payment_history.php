<?php 
session_start();
include 'db.php';

if(!isset($_SESSION['member_id'])){
    header("Location:index.php");
    exit();
}

$member_id = $_SESSION['member_id'];
$msg = "";
$msg_type = "";

// Fetch all membership plans
$plans_query = mysqli_query($conn, "SELECT * FROM membership_assign_plans ORDER BY amount ASC");
$plans = [];
while($row = mysqli_fetch_assoc($plans_query)) {
    $plans[] = $row;
}

$selected_amount = "";
$selected_plan = "";

/* When plan selected (but not paid yet) */
if(isset($_POST['plan_id']) && $_POST['plan_id'] != "" && !isset($_POST['pay'])) {
    $selected_plan = $_POST['plan_id'];

    $plan_data = mysqli_query($conn, "SELECT * FROM membership_assign_plans WHERE id='$selected_plan' LIMIT 1");
    if(mysqli_num_rows($plan_data) > 0){
        $plan_row = mysqli_fetch_assoc($plan_data);
        $selected_amount = $plan_row['amount'];
    }
}

/* Handle Payment */
if(isset($_POST['pay'])){

    $selected_plan = $_POST['plan_id'];
    $amount = $_POST['amount'];

    if($selected_plan == ""){
        $msg = "❌ Please select a membership plan first!";
        $msg_type = "danger";
    }
    elseif($amount == "" || !is_numeric($amount)){
        $msg = "❌ Invalid payment amount!";
        $msg_type = "danger";
    }
    else{

        mysqli_query($conn, "INSERT INTO payments(member_id, amount, pay_date) 
                             VALUES('$member_id', '$amount', CURDATE())");

        $plan_query = mysqli_query($conn, "SELECT * FROM membership_assign_plans WHERE id='$selected_plan' LIMIT 1");
        $plan = mysqli_fetch_assoc($plan_query);

        if($plan){
            $check_plan = mysqli_query($conn, "SELECT * FROM member_plans WHERE member_id='$member_id'");
            if(mysqli_num_rows($check_plan) > 0){
                mysqli_query($conn, "UPDATE member_plans 
                                     SET plan_id='{$plan['id']}', assign_date=CURDATE() 
                                     WHERE member_id='$member_id'");
            } else {
                mysqli_query($conn, "INSERT INTO member_plans(member_id, plan_id, assign_date) 
                                     VALUES('$member_id', '{$plan['id']}', CURDATE())");
            }
        }

        $msg = "✅ Payment of ₹$amount successfully recorded and plan updated!";
        $msg_type = "success";

        $selected_amount = "";
        $selected_plan = "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Make Payment</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#243b55;
    font-family:'Segoe UI', sans-serif;
    margin:0;
    min-height:100vh;
    display:flex;
    flex-direction:column;
}

/* CENTER WRAPPER */
.main-wrapper{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px 15px;
}

.payment-card{
    width:100%;
    max-width:480px;
    border-radius:16px;
    overflow:hidden;
    background:#ffffff;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
    animation:fadeIn 0.5s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px)}
    to{opacity:1; transform:translateY(0)}
}

.payment-header{
    background:linear-gradient(135deg,#0d6efd,#0b5ed7);
    color:#fff;
    padding:20px;
    font-size:1.2rem;
    font-weight:600;
    text-align:center;
}

.payment-body{
    padding:25px;
}

.form-label{
    font-weight:600;
    font-size:0.9rem;
}

.form-control{
    border-radius:10px;
    padding:10px 12px;
    border:1px solid #ced4da;
}

.form-control:focus{
    border-color:#0d6efd;
    box-shadow:0 0 0 0.15rem rgba(13,110,253,.25);
}

.btn-pay{
    background:#0d6efd;
    color:#fff;
    font-weight:600;
    border-radius:10px;
    padding:10px;
    transition:0.3s;
}

.btn-pay:hover{
    background:#0b5ed7;
    transform:translateY(-2px);
}

.btn-history{
    border-radius:10px;
    font-weight:500;
    border:1px solid #0d6efd;
    color:#0d6efd;
    transition:0.3s;
}

.btn-history:hover{
    background:#0d6efd;
    color:#fff;
}

.alert{
    border-radius:10px;
    font-size:0.9rem;
}
</style>
</head>

<body>

<nav class="navbar bg-primary navbar-dark px-3 px-md-4 shadow">
    <span class="navbar-brand fw-semibold">💳 Payment</span>
    <a href="member_dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="main-wrapper">
    <div class="payment-card">

        <div class="payment-header">
            Make a Payment
        </div>

        <div class="payment-body">

            <?php if($msg != ""): ?>
                <div class="alert alert-<?= $msg_type ?> text-center mb-3">
                    <?= $msg ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Select Membership Plan</label>
                    <select name="plan_id" class="form-control" required>
                        <option value="">-- Select Plan --</option>
                        <?php foreach($plans as $plan): ?>
                            <option value="<?= $plan['id'] ?>" <?= ($selected_plan == $plan['id']) ? 'selected' : '' ?>>
                                <?= $plan['plan_name'] ?> (₹<?= $plan['amount'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Enter Amount (₹)</label>
                    <input type="number" 
                           name="amount"
                           value="<?= $selected_amount ?>"
                           class="form-control"
                           placeholder="₹ 0"
                           required>
                </div>

                <button type="submit" name="pay" class="btn btn-pay w-100 mb-2">
                    Pay Now 💳
                </button>

            </form>

            <a href="view_payment_record.php" class="btn btn-history w-100">
                View Payment Records
            </a>

        </div>
    </div>
</div>

</body>
</html>
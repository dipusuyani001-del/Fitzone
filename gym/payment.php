<?php 
include 'db.php';

/* TRAINER PAYMENT LOGIC */
$trainer_id = "";
$amount     = "";
$msg = "";
$error = "";

/* PAYMENT SUBMIT */
if(isset($_POST['pay'])){
    $trainer_id = $_POST['trainer_id'];
    $amount     = $_POST['amt'];

    if($trainer_id==""){
        $error = "Please select trainer";
    }
    else if($amount=="" || $amount<=0){
        $error = "Enter valid amount";
    }
    else{
        mysqli_query($conn,
            "INSERT INTO trainer_payments(trainer_id,amount,pay_date)
             VALUES('$trainer_id','$amount',NOW())"
        );
        $msg = "Trainer Payment Successfully!";
    }
}

/* POPUP SHOW CHECK */
$showPopup = false;
if(isset($_GET['history']) && $_GET['history']=="1"){
    $showPopup = true;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Trainer Payment</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(to right,#141e30,#243b55);
    min-height:100vh;
    margin:0;
}

/* ===== CENTER TRAINER PAYMENT BOX ===== */
.main-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:calc(100vh - 56px); /* navbar height adjust */
    padding:20px;
}

.payment-card{
    width:100%;
    max-width:500px;
}

/* ================= POPUP CENTER FIX ================= */

.popup-overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100vh;
    background:rgba(0,0,0,0.6);

    display:flex;
    justify-content:center;
    align-items:center;
}

.popup-box{
    background:white;
    width:100%;
    max-width:900px;
    max-height:85vh;
    overflow:auto;
    border-radius:10px;
    padding:20px;
    box-shadow:0 0 20px rgba(0,0,0,0.4);
}

.table-responsive{
    overflow-x:auto;
}

@media(max-width:576px){
    .popup-box{
        padding:15px;
    }
}
</style>

</head>
<body>

<nav class="navbar bg-dark navbar-dark px-3 px-md-4 shadow">
    <span class="navbar-brand fw-bold">💳 Trainer Payment</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="main-wrapper">

<div class="payment-card">
<div class="card shadow p-4">

<h4 class="text-center mb-4">💳 Trainer Payment</h4>

<?php if($error!=""){ ?>
<div class="alert alert-danger text-center"><?= $error ?></div>
<?php } ?>

<?php if($msg!=""){ ?>
<div class="alert alert-success text-center"><?= $msg ?></div>
<?php } ?>

<form method="post">

<select name="trainer_id" class="form-control mb-3" required>
<option value="">-- Select Trainer --</option>
<?php
$trainers = mysqli_query($conn,"SELECT id,name FROM trainers");
while($t = mysqli_fetch_assoc($trainers)){
    $sel = ($trainer_id==$t['id'])?"selected":"";  
    echo "<option value='{$t['id']}' $sel>{$t['name']}</option>";
}
?>
</select>

<input type="number" name="amt" class="form-control mb-3"
placeholder="Payment Amount"
value="<?= htmlspecialchars($amount) ?>" required>

<button name="pay" class="btn btn-warning w-100 fw-bold mb-3">
💸 Pay Trainer
</button>

</form>

<div class="text-center">
<a href="?history=1" class="fw-bold text-decoration-none text-primary">
📜 View Payment History
</a>
</div>

</div>
</div>

</div>

<!-- ================= POPUP BOX ================= -->
<?php if($showPopup){ ?>

<div class="popup-overlay">

<div class="popup-box">

<div class="d-flex justify-content-between mb-3">
<h5 class="fw-bold">Trainer Payment History</h5>
<a href="payment.php" class="btn btn-sm btn-danger">Close</a>
</div>

<div class="table-responsive">
<table class="table table-bordered text-center">
<thead class="table-dark">
<tr>
<th>#</th>
<th>Trainer Name</th>
<th>Amount</th>
<th>Payment Time</th>
</tr>
</thead>
<tbody>

<?php
$i=1;
$h = mysqli_query($conn,"
    SELECT t.name,p.amount,p.pay_date
    FROM trainer_payments p
    JOIN trainers t ON p.trainer_id=t.id
    ORDER BY p.pay_date DESC
");

if(mysqli_num_rows($h)>0){
    while($r=mysqli_fetch_assoc($h)){
?>

<tr>
<td><?= $i++ ?></td>
<td><?= $r['name'] ?></td>
<td>₹<?= $r['amount'] ?></td>
<td><?= date("d-m-Y h:i A",strtotime($r['pay_date'])) ?></td>
</tr>

<?php } }
else{
echo "<tr><td colspan='4'>No records found</td></tr>";
}
?>

</tbody>
</table>
</div>

</div>
</div>

<?php } ?>
<!-- ===================================================== -->

</body>
</html>
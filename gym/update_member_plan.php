<?php
session_start();
$conn = mysqli_connect("localhost","root","","gym_db");

if(!isset($_SESSION['admin'])){
    header("Location:index.php");
    exit();
}

/* ---------- GET PLAN ID ---------- */
if(!isset($_GET['id'])){
    header("Location:member_plan.php");
    exit();
}

$plan_id = $_GET['id'];

/* ---------- FETCH CURRENT RECORD ---------- */
$result = mysqli_query($conn,"
    SELECT * FROM member_plans WHERE id='$plan_id'
");
if(mysqli_num_rows($result) == 0){
    header("Location:member_plan.php");
    exit();
}

$plan = mysqli_fetch_assoc($result);
$msg = "";

/* ---------- UPDATE LOGIC ---------- */
if(isset($_POST['save'])){
    $member_id = $_POST['member_id'];
    $plan_assign_id = $_POST['plan_id'];
    $assign_date = $_POST['assign_date'];

    $update = "UPDATE member_plans 
               SET member_id='$member_id',
                   plan_id='$plan_assign_id',
                   assign_date='$assign_date'
               WHERE id='$plan_id'";

    if(mysqli_query($conn,$update)){
        $msg = "<div class='alert alert-success text-center'>✅ Plan Updated Successfully</div>";
    } else {
        $msg = "<div class='alert alert-danger text-center'>❌ Error Updating Plan</div>";
    }
}

/* ---------- FETCH MEMBERS & PLANS ---------- */
$members = mysqli_query($conn,"SELECT * FROM members");
$plans   = mysqli_query($conn,"SELECT * FROM membership_assign_plans");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Member Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">

<!-- NAVBAR -->
<nav class="navbar bg-dark navbar-dark px-4 shadow">
    <span class="navbar-brand fw-bold">✏️ Edit Member Plan</span>
    <a href="member_plan.php" class="btn btn-light btn-sm">Back</a>
</nav>

<!-- EDIT CARD -->
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg p-4 w-100" style="max-width:500px;">
        <h3 class="text-center mb-4">Edit Membership Plan</h3>

        <?= $msg ?>

        <form method="post">

            <!-- MEMBER SELECT -->
            <div class="mb-3">
                <label class="form-label fw-bold">Select Member</label>
                <select name="member_id" class="form-control" required>
                    <option value="">-- Select Member --</option>
                    <?php while($m = mysqli_fetch_assoc($members)): ?>
                        <option value="<?= $m['id'] ?>" 
                            <?= ($m['id'] == $plan['member_id']) ? 'selected' : '' ?>>
                            <?= $m['name'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- PLAN SELECT -->
            <div class="mb-3">
                <label class="form-label fw-bold">Select Plan</label>
                <select name="plan_id" class="form-control" required>
                    <option value="">-- Select Plan --</option>
                    <?php while($p = mysqli_fetch_assoc($plans)): ?>
                        <option value="<?= $p['id'] ?>"
                            <?= ($p['id'] == $plan['plan_id']) ? 'selected' : '' ?>>
                            <?= $p['plan_name'] ?> (<?= $p['months'] ?> Months - ₹<?= $p['amount'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- ASSIGN DATE -->
            <div class="mb-4">
                <label class="form-label fw-bold">Assign Date</label>
                <input type="date" name="assign_date" class="form-control" 
                       value="<?= $plan['assign_date'] ?>" required>
            </div>
            <!-- SAVE BUTTON -->
            <button name="save" class="btn btn-success w-100 fw-bold">
                Save Changes
            </button>

        </form>
    </div>
</div>

</body>
</html>

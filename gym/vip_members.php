<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location:index.php");
    exit();
}

$msg = "";

/* ---------- MAKE VIP ---------- */
if(isset($_POST['make_vip'])){

    $member_id = $_POST['member_id'];
    $months    = $_POST['months'];

    if($member_id!="" && $months!=""){

        $expiry = date('Y-m-d', strtotime("+$months months"));

        mysqli_query($conn,
            "UPDATE members 
             SET vip_status='VIP',
                 vip_expiry='$expiry'
             WHERE id='$member_id'"
        );

        $msg = "Member Upgraded to VIP Successfully 🎉";
    }
}

/* ---------- REMOVE VIP ---------- */
if(isset($_GET['remove'])){

    $id = $_GET['remove'];

    mysqli_query($conn,
        "UPDATE members 
         SET vip_status='Normal',
             vip_expiry=NULL
         WHERE id='$id'"
    );

    $msg = "VIP Removed Successfully";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>VIP Members</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(to right,#141e30,#243b55);
    min-height:100vh;
    margin:0;
    overflow-x:hidden;
}

/* ===== CENTER WRAPPER ===== */
.main-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:calc(100vh - 56px);
    padding:15px;
}

/* ===== CARD STYLE ===== */
.card{
    border-radius:15px;
    animation:fadeIn .4s ease;
    width:100%;
    max-width:550px;
}

@keyframes fadeIn{
    from{opacity:0; transform:scale(.95)}
    to{opacity:1; transform:scale(1)}
}

/* ===== MOBILE OPTIMIZATION ===== */
@media(max-width:576px){

    .main-wrapper{
        padding:10px;
    }

    .card{
        max-width:100%;
    }

    h4{
        font-size:18px;
    }

    .navbar-brand{
        font-size:16px;
    }

    .btn{
        font-size:14px;
    }

    table{
        font-size:13px;
    }
}
</style>

</head>
<body>

<nav class="navbar bg-dark navbar-dark px-4 shadow">
    <span class="navbar-brand fw-bold">⭐ VIP Member Management</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="main-wrapper">

<div class="card shadow-lg">
<div class="card-body">

<h4 class="text-center mb-4">Upgrade Member to VIP</h4>

<?php if($msg!=""){ ?>
<div class="alert alert-success text-center">
    <?= $msg ?>
</div>
<?php } ?>

<form method="post">

<select name="member_id" class="form-control mb-3" required>
<option value="">-- Select Member --</option>
<?php
$m = mysqli_query($conn,"SELECT id,name FROM members");
while($row=mysqli_fetch_assoc($m)){
echo "<option value='{$row['id']}'>{$row['name']}</option>";
}
?>
</select>

<select name="months" class="form-control mb-3" required>
<option value="">-- VIP Duration --</option>
<option value="1">1 Month</option>
<option value="3">3 Months</option>
<option value="6">6 Months</option>
<option value="12">12 Months</option>
</select>

<button name="make_vip" class="btn btn-warning w-100 fw-bold mb-3">
    ⭐ Make VIP Member
</button>

</form>

<button type="button" class="btn btn-dark w-100"
        data-bs-toggle="modal"
        data-bs-target="#vipModal">
    👑 View VIP Members List
</button>

</div>
</div>

</div>


<!-- ✅ VIP MODAL POPUP -->
<div class="modal fade" id="vipModal" tabindex="-1">
<div class="modal-dialog modal-xl modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-dark text-white">
    <h5 class="modal-title">VIP Members List</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="table-responsive">
<table class="table table-bordered table-hover text-center">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Name</th>
<th>Status</th>
<th>Expiry Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php
$q = mysqli_query($conn,"SELECT * FROM members WHERE vip_status='VIP'");

while($r=mysqli_fetch_assoc($q)){

$status = "VIP";
$expiry = $r['vip_expiry'];

if($expiry < date('Y-m-d')){
    $status = "Expired";
}

echo "<tr>
<td>{$r['id']}</td>
<td>{$r['name']}</td>
<td>$status</td>
<td>$expiry</td>
<td>
<a href='vip_members.php?remove={$r['id']}' 
   class='btn btn-sm btn-danger'>
   Remove VIP
</a>
</td>
</tr>";
}
?>
</tbody>

</table>
</div>

</div>

</div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
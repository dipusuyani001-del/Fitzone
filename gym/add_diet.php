<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin'])){
    header("Location:index.php");
    exit();
}

$msg = "";

if(isset($_POST['save'])){
    
    $member_id = $_POST['member_id'];
    $category  = $_POST['category'];

    if($member_id != "" && $category != ""){

        if($category == "muscle"){

            $title = "Muscle Gain Diet Plan";

            $desc = "
            🥣 Breakfast:4 Eggs (24g Protein),Oats (10g Protein),1 Banana
            -------------------------
            🍗 Lunch:200g Chicken Breast (50g Protein),Rice + Salad
            -------------------------
            🥜 Evening Snack:Peanut Butter Sandwich (15g Protein),Banana Shake (10g Protein)
            -------------------------
            🍽 Dinner:150g Paneer (30g Protein),2 Roti + Vegetables
            -------------------------
            💪 Total Daily Protein: 130g - 150g
            ";

            $calories = "2800 - 3200 Calories";
            $total_protein = "130 - 150g";
        }

        elseif($category == "fitness"){

            $title = "General Fitness Diet Plan";

            $desc = "
            🥣 Breakfast:2 Eggs (12g Protein),Brown Bread (6g Protein),Fruits
            -------------------------
            🍛 Lunch:Dal (15g Protein),2 Roti + Rice,Salad
            -------------------------
            🥛 Evening Snack:Milk (8g Protein),Handful Almonds (6g Protein)
            -------------------------
            🍽 Dinner:Paneer / Soyabean (20g Protein),Vegetables + Roti
            -------------------------
            🏃 Total Daily Protein: 60g - 80g
            ";

            $calories = "2000 - 2300 Calories";
            $total_protein = "60 - 80g";
        }

        mysqli_query($conn,"INSERT INTO diet_plans
        (member_id,plan_title,description,calories,total_protein)
        VALUES
        ('$member_id','$title','$desc','$calories','$total_protein')");

        $msg = "Diet Plan Added Successfully ✅";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Diet Plan</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(to right,#141e30,#243b55);
    min-height:100vh;
    margin:0;
}

/* ===== CENTER FIX ===== */
.main-wrapper{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:calc(100vh - 56px);
    padding:20px;
}

.card{
    border-radius:15px;
    animation:fadeIn .5s ease;
    width:100%;
    max-width:500px; /* better mobile control */
}

@keyframes fadeIn{
    from{opacity:0; transform:scale(.95)}
    to{opacity:1; transform:scale(1)}
}

/* Mobile Improvements */
@media(max-width:576px){

    .card{
        padding:5px;
    }

    h4{
        font-size:18px;
    }

    .navbar-brand{
        font-size:16px;
    }

}
</style>

</head>

<body>

<nav class="navbar bg-dark navbar-dark px-4">
    <span class="navbar-brand fw-bold">🥗 Add Diet Plan</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="main-wrapper">

<div class="card shadow-lg">
<div class="card-body">

<h4 class="text-center mb-4">Create Diet Plan</h4>

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

<select name="category" class="form-control mb-3" required>
<option value="">-- Select Plan Type --</option>
<option value="muscle">Muscle Gain Plan</option>
<option value="fitness">General Fitness Plan</option>
</select>

<button name="save" class="btn btn-success w-100 fw-bold">
    Save Diet Plan
</button>

</form>

</div>
</div>

</div>

</body>
</html>
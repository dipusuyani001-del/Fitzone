<?php
include 'db.php';

$id = $_GET['id'];
$q = mysqli_query($conn,"SELECT * FROM members WHERE id='$id'");
$row = mysqli_fetch_assoc($q);

if(isset($_POST['update'])){
    mysqli_query($conn,"UPDATE members SET 
        name='$_POST[name]',
        email='$_POST[email]',
        phone='$_POST[phone]'
        WHERE id='$id'
    ");
    header("Location: view_members.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>

    <!-- ✅ Mobile Responsive Important -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        /* Disable horizontal scroll */
        html, body{
            overflow-x:hidden;
        }

        body.dashboard-page{
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }

        /* Center wrapper */
        .main-wrapper{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px 10px;
        }

        /* Form Card */
        .member-card{
            width:100%;
            max-width:450px;
            background:#fff;
            padding:30px;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }

        .member-card h3{
            text-align:center;
            margin-bottom:25px;
        }

        /* Mobile adjustments */
        @media(max-width:576px){

            .member-card{
                padding:20px;
            }

            .member-card h3{
                font-size:20px;
            }

            .form-control{
                font-size:14px;
            }

            .btn{
                font-size:14px;
            }
        }
    </style>
</head>

<body class="dashboard-page">

<!-- NAVBAR -->
<nav class="navbar bg-dark navbar-dark px-3 px-md-4 shadow">
    <span class="navbar-brand fw-bold">👤 Member List</span>
    <a href="view_members.php" class="btn btn-light btn-sm">Back</a>
</nav>

<!-- ✅ CENTERED FORM -->
<div class="main-wrapper">
    <div class="member-card">

        <h3>Edit Member</h3>

        <form method="post">
            <input name="name" class="form-control mb-3" value="<?= $row['name'] ?>">
            <input name="email" class="form-control mb-3" value="<?= $row['email'] ?>">
            <input name="phone" class="form-control mb-3" value="<?= $row['phone'] ?>">

            <button name="update" class="btn btn-primary w-100">
                Update Member
            </button>
        </form>

    </div>
</div>

</body>
</html>
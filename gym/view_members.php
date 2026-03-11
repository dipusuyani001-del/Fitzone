<?php 
include 'db.php';

/* DELETE MEMBER */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn,"DELETE FROM members WHERE id='$id'");
    header("Location: view_members.php");
    exit();
}

$q = mysqli_query($conn,"SELECT * FROM members");
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Members</title>

    <!-- ✅ Mobile Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <style>
        body.dashboard-page{
            min-height:100vh;
            display:flex;
            flex-direction:column;
        }

        /* ✅ Center wrapper */
        .main-wrapper{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px 10px;
        }

        /* ✅ White Box */
        .view-card{
            width:100%;
            max-width:1100px;
            background:#fff;
            padding:25px;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
        }

        /* ✅ Scroll only table */
        .table-scroll{
            max-height:400px;
            overflow-y:auto;
        }

        .table-scroll::-webkit-scrollbar{
            width:8px;
        }
        .table-scroll::-webkit-scrollbar-thumb{
            background:#6c757d;
            border-radius:10px;
        }
        .table-scroll::-webkit-scrollbar-track{
            background:#f1f1f1;
        }

        /* ✅ Mobile Adjustments */
        @media(max-width:768px){

            .view-card{
                padding:15px;
            }

            .table-scroll{
                max-height:300px;
            }

            td .btn{
                display:block;
                width:100%;
                margin-bottom:5px;
            }

            td{
                font-size:14px;
                white-space:nowrap;
            }
        }
    </style>
</head>

<body class="dashboard-page">

<!-- NAVBAR -->
<nav class="navbar bg-dark navbar-dark px-3 px-md-4 shadow sticky-top">
    <span class="navbar-brand fw-bold">👤 Members</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
</nav>

<!-- ✅ CENTERED WHITE BOX -->
<div class="main-wrapper">

    <div class="view-card">

        <h3 class="text-center mb-4">👤 Member List</h3>

        <div class="table-responsive table-scroll">
            <table class="table table-hover member-table mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php while($r=mysqli_fetch_assoc($q)){ ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><?= $r['name'] ?></td>
                        <td><?= $r['email'] ?></td>
                        <td><?= $r['password'] ?></td>
                        <td><?= $r['phone'] ?></td>
                        <td>
                            <a href="edit_member.php?id=<?= $r['id'] ?>" 
                               class="btn btn-sm btn-primary">
                                Edit
                            </a>

                            <a href="view_members.php?delete=<?= $r['id'] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure to delete this member?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>
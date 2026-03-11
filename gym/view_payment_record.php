<?php
session_start();
include 'db.php';

if(!isset($_SESSION['member_id'])){
    header("Location:index.php");
    exit();
}

$member_id = $_SESSION['member_id'];

$payments = mysqli_query($conn, "SELECT * FROM payments WHERE member_id='$member_id' ORDER BY pay_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment History</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#eef2f7;
            font-family:'Segoe UI', sans-serif;
            overflow-x:hidden;
        }

        .history-wrapper{
            padding:40px 15px;
        }

        .history-card{
            max-width:800px;
            margin:auto;
            border-radius:18px;
            overflow:hidden;
            background:#ffffff;
            box-shadow:0 15px 35px rgba(0,0,0,0.08);
            animation:fadeIn 0.5s ease;
        }

        @keyframes fadeIn{
            from{opacity:0; transform:translateY(20px)}
            to{opacity:1; transform:translateY(0)}
        }

        .history-header{
            background:linear-gradient(135deg,#0d6efd,#0b5ed7);
            color:#fff;
            padding:22px;
            text-align:center;
            font-size:1.3rem;
            font-weight:600;
            letter-spacing:0.5px;
        }

        .table{
            margin-bottom:0;
        }

        .table thead th{
            font-weight:600;
            font-size:0.9rem;
            background:#f8f9fa;
            border:none;
        }

        .table tbody tr{
            transition:0.3s;
        }

        .table tbody tr:hover{
            background:#f1f5ff;
        }

        .table td{
            border:none;
            padding:14px 10px;
        }

        .badge{
            padding:6px 10px;
            font-size:0.75rem;
            border-radius:20px;
        }

        /* Mobile Optimization */
        @media(max-width:576px){

            .history-header{
                font-size:1.05rem;
                padding:18px;
            }

            .table td,
            .table th{
                font-size:0.8rem;
                padding:10px 6px;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-primary px-3 px-md-4 shadow-sm">
    <span class="navbar-brand fw-semibold">📄 Payment History</span>
    <a href="payment_history.php" class="btn btn-light btn-sm">Back</a>
</nav>

<div class="history-wrapper">

    <div class="history-card">

        <div class="history-header">
            💳 All Payment Records
        </div>

        <div class="table-responsive p-3">

            <table class="table align-middle text-center">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Amount (₹)</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                if(mysqli_num_rows($payments) > 0){
                    $i = 1;
                    while($row = mysqli_fetch_assoc($payments)){
                        $status = ($row['pay_date'] == date("Y-m-d"))
                            ? "<span class='badge bg-success'>Recent</span>"
                            : "<span class='badge bg-secondary'>Completed</span>";
                ?>
                    <tr>
                        <td class="fw-semibold"><?= $i++ ?></td>
                        <td class="fw-bold text-primary">₹<?= $row['amount'] ?></td>
                        <td><?= date("d M Y", strtotime($row['pay_date'])) ?></td>
                        <td><?= $status ?></td>
                    </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-muted py-4">No payment records found.</td></tr>';
                }
                ?>
                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
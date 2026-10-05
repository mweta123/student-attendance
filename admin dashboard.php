<?php
session_start();
require 'CONNECTION.PHP';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: LOGIN.PHP");
    exit;
}

$today = date('Y-m-d');

/* Total Students */
$total_query = mysqli_query(
    $connection,
    "SELECT COUNT(*) AS total FROM users WHERE role='student'"
);

$total = mysqli_fetch_assoc($total_query);


/* Present Today */
$present_query = mysqli_query(
    $connection,
    "SELECT COUNT(*) AS total
     FROM attendance
     WHERE date='$today'
     AND status='present'
     AND confirmed=1"
);

$present = mysqli_fetch_assoc($present_query);


/* Absent Today */
$absent_query = mysqli_query(
    $connection,
    "SELECT COUNT(*) AS total
     FROM attendance
     WHERE date='$today'
     AND status='absent'
     AND confirmed=1"
);

$absent = mysqli_fetch_assoc($absent_query);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f4f7fc;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            width: 200px;
            height: 100vh;
            background: #4dd0e1;
            padding: 20px;
        }

        .sidebar h2 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin: 6px 0;
            background: #26c6da;
        }

        .sidebar a:hover {
            background: #00acc1;
        }

        .logout {
            background: #807b7b !important;
            margin-top: 25px !important;
        }

        /* MAIN */

        .main {
            margin-left: 200px;
            padding: 30px;
        }

        h1 {
            color: #00838f;
        }

        .welcome {
            background: #3bffff;
            padding: 20px;
            margin: 20px 0;
        }

        .welcome h2 {
            margin: 0 0 5px;
        }

        /* CARDS */

        .cards {
            display: flex;
            gap: 15px;
        }

        .card {
            background: white;
            padding: 20px;
            flex: 1;
            text-align: center;
            border: 2px solid #4dd0e1;
        }

        .card h3 {
            margin: 0 0 10px;
        }

        .number {
            font-size: 30px;
            font-weight: bold;
            color: #0097a7;
        }

        .present {
            color: green;
        }

        .absent {
            color: red;
        }

        /* MOBILE */

        @media (max-width: 700px) {

            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
            }

            .cards {
                display: block;
            }

            .card {
                margin-bottom: 15px;
            }
        }

    </style>

</head>


<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <h2> Attendance</h2>

    <a href="admin dashboard.php">
         Dashboard
    </a>
 

    <a href="add student.php">
        Add Student
    </a>

    <a href="attendance.php">
         Attendance
    </a>

    <a href="logout.php" class="logout">
         Logout
    </a>

</div>


<!-- MAIN -->

<div class="main">

    <h1>Admin</h1>

    <div class="welcome">

        <h2>
            Welcome,
            <?php echo htmlspecialchars($_SESSION['full_name']); ?>
        </h2>

        <p>
            Manage students and attendance here.
        </p>

    </div>


    <!-- SUMMARY -->

    <div class="cards">

        <div class="card">

            <h3>Total Students</h3>

            <div class="number">
                <?php echo $total['total']; ?>
            </div>

        </div>


        <div class="card">

            <h3>Present Today</h3>

            <div class="number present">
                <?php echo $present['total']; ?>
            </div>

            <p>
                <?php echo $today; ?>
            </p>

        </div>


        <div class="card">

            <h3>Absent Today</h3>

            <div class="number absent">
                <?php echo $absent['total']; ?>
            </div>

            <p>
                <?php echo $today; ?>
            </p>

        </div>

    </div>

</div>


</body>

</html>
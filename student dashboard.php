```php
<?php
session_start();
require 'CONNECTION.PHP';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: LOGIN.PHP");
    exit;
}

$email = $_SESSION['email'];

$result = mysqli_query($connection,
    "SELECT * FROM users WHERE email='$email' LIMIT 1"
);

$user = mysqli_fetch_assoc($result);

if (!$user) {
    header("Location: LOGIN.PHP");
    exit;
}

$id = $user['id'];
$name = $user['full_name'];
$today = date('Y-m-d');
$msg = "";


if (isset($_POST['sign'])) {

    $check = mysqli_query($connection,
        "SELECT id FROM attendance
         WHERE user_id='$id' AND date='$today'"
    );

    if (mysqli_num_rows($check) == 0) {

        mysqli_query($connection,
            "INSERT INTO attendance
            (user_id, date, status, confirmed)
            VALUES ('$id', '$today', 'present', 0)"
        );

        $msg = "Attendance signed. Waiting for admin confirmation.";

    } else {

        $msg = "You already signed today.";
    }
}

$today_result = mysqli_query($connection,
    "SELECT * FROM attendance
     WHERE user_id='$id' AND date='$today'
     LIMIT 1"
);

$today_att = mysqli_fetch_assoc($today_result);


$records = mysqli_query($connection,
    "SELECT * FROM attendance
     WHERE user_id='$id'
     ORDER BY date DESC"
);

$total = mysqli_num_rows($records);
?>

<!DOCTYPE html>
<html>
<head>

<title>Student Dashboard</title>

<style>

*{
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    margin:0;
    background:#f4f7f9;
    color:#333;
}


.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:210px;
    height:100vh;
    background:#087f8c;
    color:white;
    padding:25px 15px;
}

.logo{
    text-align:center;
    margin-bottom:35px;
}

.logo h2{
    margin:0;
}

.profile{
    text-align:center;
    margin-bottom:30px;
}

.icon{
    width:55px;
    height:55px;
    margin:auto;
    background:white;
    color:#087f8c;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    font-weight:bold;
}

.menu a{
    display:block;
    color:white;
    text-decoration:none;
    padding:12px;
    margin:8px 0;
    border-radius:6px;
}

.menu a:hover{
    background:#066c76;
}

.logout{
    background:lightblue;
    margin-top:25px !important;
}


.main{
    margin-left:210px;
    padding:30px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.header h1{
    color:#087f8c;
}

.date{
    background:white;
    padding:10px 15px;
    border-radius:6px;
}


.welcome,
.sign,
.history{
    background:white;
    padding:20px;
    margin-top:20px;
    border-radius:8px;
}

.cards{
    display:flex;
    gap:15px;
    margin-top:20px;
}

.card{
    flex:1;
    background:white;
    padding:18px;
    border-radius:8px;
    text-align:center;
}

.number{
    font-size:25px;
    font-weight:bold;
    color:#087f8c;
}


.message{
    background:#fff3cd;
    color:#856404;
    padding:10px;
    margin-top:15px;
    border-radius:5px;
}


button{
    background:#00a878;
    color:white;
    border:0;
    padding:11px 20px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#008f68;
}



.status{
    display:inline-block;
    padding:6px 10px;
    border-radius:15px;
    font-size:12px;
}

.pending{
    background:#fff3cd;
    color:#856404;
}

.present{
    background:#dff7e8;
    color:#14833b;
}

.absent{
    background:#fde2e2;
    color:#c0392b;
}



table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:11px;
    text-align:left;
    border-bottom:1px solid #eee;
}

th{
    background:#087f8c;
    color:white;
}


/* MOBILE */

@media(max-width:700px){

    .sidebar{
        position:relative;
        width:100%;
        height:auto;
    }

    .main{
        margin-left:0;
        padding:15px;
    }

    .cards{
        display:block;
    }

    .card{
        margin-bottom:10px;
    }

    .header{
        display:block;
    }

    .date{
        margin-top:10px;
    }


    .logout{
        background-color: #087f8c;
    }
}

</style>

</head>

<body>


<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">
        <h2>Attendance</h2>
        <small>Student System</small>
    </div>

    <div class="profile">

        <div class="icon">
            <?php echo strtoupper(substr($name,0,1)); ?>
        </div>

        <p><?php echo htmlspecialchars($name); ?></p>

    </div>

    <div class="menu">

        <a href="student dashboard.php">
             Dashboard
        </a>

        <a href="logout.php" class="logout">
            Logout
        </a>

    </div>

</div>

<div class="main">

    <div class="header">

        <h1>Student Dashboard</h1>

        <div class="date">
            <?php echo $today; ?>
        </div>

    </div>


    <div class="welcome">

        <h2>
            Welcome, <?php echo htmlspecialchars($name); ?> 
        </h2>

        <p>Manage your attendance here.</p>

    </div>


    <?php if($msg != ""){ ?>

        <div class="message">
            <?php echo $msg; ?>
        </div>

    <?php } ?>

    <div class="cards">

        <div class="card">
            <h4>Total Attendance</h4>
            <div class="number">
                <?php echo $total; ?>
            </div>
        </div>

        <div class="card">
            <h4>Today</h4>
            <div class="number">
                <?php echo $today; ?>
            </div>
        </div>

        <div class="card">
            <h4>Role</h4>
            <div class="number">
                Student
            </div>
        </div>

    </div>

    <div class="sign">

        <h2>Today's Attendance</h2>

        <?php if(!$today_att){ ?>

            <p>Are you present today?</p>

            <form method="POST">

                <button type="submit" name="sign">
                    ✓ I Am Present
                </button>

            </form>

        <?php } elseif($today_att['confirmed'] == 0){ ?>

            <span class="status pending">
                Waiting for Admin Confirmation
            </span>

        <?php } elseif($today_att['status'] == 'present'){ ?>

            <span class="status present">
                ✓ Present - Confirmed
            </span>

        <?php } else { ?>

            <span class="status absent">
                Absent
            </span>

        <?php } ?>

    </div>

    <div class="history">

        <h2>Attendance History</h2>

        <table>

            <tr>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <?php if(mysqli_num_rows($records) > 0){ ?>

                <?php while($row = mysqli_fetch_assoc($records)){ ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($row['date']); ?>
                    </td>

                    <td>

                        <?php if($row['confirmed'] == 0){ ?>

                            <span class="status pending">
                                Pending
                            </span>

                        <?php } elseif($row['status'] == 'present'){ ?>

                            <span class="status present">
                                Present
                            </span>

                        <?php } else { ?>

                            <span class="status absent">
                                Absent
                            </span>

                        <?php } ?>

                    </td>

                </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="2">
                        No attendance records yet.
                    </td>
                </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>

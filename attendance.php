<?php
session_start();
require 'CONNECTION.PHP';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: LOGIN.PHP");
    exit;
}

$message = "";

/* Admin takes attendance */
if (isset($_POST['save'])) {

    $date = $_POST['date'];

    foreach ($_POST['status'] as $user_id => $status) {

        $user_id = (int)$user_id;

        $check = mysqli_query(
            $connection,
            "SELECT id FROM attendance
             WHERE user_id=$user_id AND date='$date'"
        );
        if (mysqli_num_rows($check)) {

            mysqli_query(
                $connection,
                "UPDATE attendance
                 SET status='$status', confirmed=1
                 WHERE user_id=$user_id AND date='$date'"
            );

        } else {

            mysqli_query(
                $connection,
                "INSERT INTO attendance
                (user_id, date, status, confirmed)
                VALUES
                ($user_id, '$date', '$status', 1)"
            );
        }
    }

    $message = "Attendance saved successfully";
}


/* Confirm attendance submitted by student */
if (isset($_GET['confirm'])) {

    $attendance_id = (int)$_GET['confirm'];

    mysqli_query(
        $connection,
        "UPDATE attendance
         SET confirmed=1
         WHERE id=$attendance_id"
    );

    header("Location: attendance.php");
    exit;
}

$students = mysqli_query(
    $connection,
    "SELECT * FROM users WHERE role='student'"
);

$attendance = mysqli_query(
    $connection,
    "SELECT attendance.*, users.full_name
     FROM attendance
     JOIN users ON attendance.user_id = users.id
     ORDER BY attendance.date DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Attendance</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial;
        }

        body {
            margin: 0;
            background: #f4f7fc;
        }

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
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin: 5px 0;
        }

        .sidebar a:hover {
            background: #00acc1;
        }

        .main {
            margin-left: 220px;
            padding: 25px;
        }

        .box {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
        }

        input, select {
            padding: 10px;
        }

        button {
            background: #00a884;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #4dd0e1;
            color: white;
        }

        .confirm {
            background: green;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .confirmed {
            color: green;
            font-weight: bold;
        }

        .pending {
            color: orange;
            font-weight: bold;
        }

    </style>

</head>

<body>
<div class="sidebar">

    <h2>Attendance</h2>

    <a href="admin dashboard.php">Dashboard</a>
    <a href="add student.php">Add Student</a>
    <a href="attendance.php">Attendance</a>
    <a href="LOGOUT.PHP">Logout</a>

</div>


<div class="main">

    <h1>Attendance</h1>


    <?php if ($message != "") { ?>

        <div class="box">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <div class="box">

        <h2>Take Attendance</h2>

        <form method="POST">

            <label>Date:</label>

            <input type="date"
                   name="date"
                   value="<?php echo date('Y-m-d'); ?>"
                   required>

            <br><br>

            <table>

                <tr>
                    <th>Student</th>
                    <th>Status</th>
                </tr>


                <?php while ($student = mysqli_fetch_assoc($students)) { ?>

                <tr>

                    <td>
                        <?php echo $student['full_name']; ?>
                    </td>

                    <td>

                        <select name="status[<?php echo $student['id']; ?>]">

                            <option value="present">
                                Present
                            </option>

                            <option value="absent">
                                Absent
                            </option>

                            <option value="late">
                                Late
                            </option>

                        </select>

                    </td>

                </tr>

                <?php } ?>

            </table>

            <br>

            <button name="save">
                Save Attendance
            </button>

        </form>

    </div>
    <div class="box">

        <h2>Student Attendance</h2>

        <table>

            <tr>
                <th>Student</th>
                <th>Date</th>
                <th>Status</th>
                <th>Confirmation</th>
            </tr>


            <?php while ($row = mysqli_fetch_assoc($attendance)) { ?>

            <tr>

                <td>
                    <?php echo $row['full_name']; ?>
                </td>

                <td>
                    <?php echo $row['date']; ?>
                </td>

                <td>
                    <?php echo ucfirst($row['status']); ?>
                </td>

                <td>

                    <?php if ($row['confirmed'] == 0) { ?>

                        <a class="confirm"
                           href="attendance.php?confirm=<?php echo $row['id']; ?>">
                           Confirm
                        </a>

                    <?php } else { ?>

                        <span class="confirmed">
                            Confirmed
                        </span>

                    <?php } ?>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>
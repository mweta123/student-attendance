
<?php

session_start();
require 'CONNECTION.PHP';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: LOGIN.PHP");
    exit;
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    mysqli_query(
        $connection,
        "DELETE FROM users
         WHERE id='$id'
         AND role='student'"
    );

    header("Location: delete student.php");
    exit;
}

$students = mysqli_query(
    $connection,
    "SELECT * FROM users
     WHERE role='student'"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Delete Student</title>

<style>

* {
    box-sizing: border-box;
    font-family: Arial, sans-serif;
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

.main {
    margin-left: 200px;
    padding: 30px;
}

h1 {
    color: #00838f;
}

.student-list {
    background: white;
    padding: 20px;
    max-width: 700px;
}

.student {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    margin-bottom: 10px;
    background: #e0f7fa;
}

.student-info {
    color: #333;
}

.delete {
    background: #e53935;
    color: white;
    padding: 10px 15px;
    text-decoration: none;
}

.delete:hover {
    background: #c62828;
}

</style>

</head>

<body>



<div class="sidebar">

    <h2>Attendance</h2>

    <a href="admin dashboard.php">
        Dashboard
    </a>

    <a href="add student.php">
        Add Student
    </a>

    <a href="edit student.php">
        Edit Student
    </a>

    <a href="delete student.php">
        Delete Student
    </a>

    <a href="attendance.php">
        Attendance
    </a>

    <a href="logout.php" class="logout">
        Logout
    </a>

</div>



<div class="main">

    <h1>Delete Student</h1>

    <div class="student-list">

        <h3>Students</h3>

        <?php while ($row = mysqli_fetch_assoc($students)) { ?>

            <div class="student">

                <div class="student-info">

                    <strong>
                        <?php echo htmlspecialchars($row['full_name']); ?>
                    </strong>

                    <br>

                    <?php echo htmlspecialchars($row['email']); ?>

                </div>


                <a
                    class="delete"
                    href="delete student.php?id=<?php echo $row['id']; ?>"
                    onclick="return confirm('Are you sure you want to delete this student?');">

                    Delete

                </a>

            </div>

        <?php } ?>

    </div>

</div>

</body>

</html>


```php
<?php

session_start();
require 'CONNECTION.PHP';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: LOGIN.PHP");
    exit;
}

$message = "";

/* GET STUDENT */

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $query = mysqli_query(
        $connection,
        "SELECT * FROM users WHERE id='$id' AND role='student'"
    );

    $student = mysqli_fetch_assoc($query);

    if (!$student) {
        die("Student not found.");
    }

} else {

    /* SHOW STUDENTS */

    $students = mysqli_query(
        $connection,
        "SELECT * FROM users WHERE role='student'"
    );
}


/* UPDATE STUDENT */

if (isset($_POST['update_student'])) {

    $id = $_POST['id'];
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);

    if ($full_name == "" || $email == "") {

        $message = "Please fill all fields.";

    } else {

        $update = mysqli_query(
            $connection,
            "UPDATE users
             SET full_name='$full_name',
                 email='$email'
             WHERE id='$id'
             AND role='student'"
        );

        if ($update) {

            $message = "Student updated successfully.";

            $query = mysqli_query(
                $connection,
                "SELECT * FROM users
                 WHERE id='$id'
                 AND role='student'"
            );

            $student = mysqli_fetch_assoc($query);

        } else {

            $message = "Failed to update student.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Edit Student</title>

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

.box {
    background: white;
    padding: 25px;
    max-width: 500px;
    border: 2px solid #4dd0e1;
}

input {
    width: 100%;
    padding: 12px;
    margin: 8px 0 15px;
    border: 1px solid #ccc;
}

button {
    background: #26c6da;
    color: white;
    border: none;
    padding: 12px 20px;
    cursor: pointer;
}

button:hover {
    background: #00acc1;
}

.message {
    color: green;
    margin-bottom: 15px;
}

.student-list {
    background: white;
    padding: 20px;
    max-width: 700px;
}

.student-list a {
    display: block;
    padding: 12px;
    margin: 8px 0;
    background: #e0f7fa;
    color: #00838f;
    text-decoration: none;
}

.student-list a:hover {
    background: #b2ebf2;
}

</style>

</head>

<body>

<!-- SIDEBAR -->

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


<!-- MAIN -->

<div class="main">

<?php if (!isset($_GET['id'])) { ?>

    <h1>Edit Student</h1>

    <div class="student-list">

        <h3>Select Student</h3>

        <?php while ($row = mysqli_fetch_assoc($students)) { ?>

            <a href="edit student.php?id=<?php echo $row['id']; ?>">

                <?php echo htmlspecialchars($row['full_name']); ?>

                -
                <?php echo htmlspecialchars($row['email']); ?>

            </a>

        <?php } ?>

    </div>


<?php } else { ?>

    <h1>Edit Student</h1>

    <div class="box">

        <?php if ($message != "") { ?>

            <div class="message">
                <?php echo $message; ?>
            </div>

        <?php } ?>

        <form method="POST">

            <input type="hidden"
                   name="id"
                   value="<?php echo $student['id']; ?>">

            <label>Full Name</label>

            <input type="text"
                   name="full_name"
                   value="<?php echo htmlspecialchars($student['full_name']); ?>"
                   required>


            <label>Email</label>

            <input type="email"
                   name="email"
                   value="<?php echo htmlspecialchars($student['email']); ?>"
                   required>


            <button type="submit"
                    name="update_student">

                Update Student

            </button>

        </form>

    </div>

<?php } ?>

</div>

</body>

</html>
```

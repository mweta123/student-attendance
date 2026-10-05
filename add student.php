```php
<?php
session_start();
require 'CONNECTION.PHP';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: LOGIN.PHP");
    exit;
}

$message = "";

if (isset($_POST['add_student'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($name == "" || $email == "" || $password == "") {

        $message = "Please fill all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email.";

    } else {

        $check = mysqli_query(
            $connection,
            "SELECT id FROM users WHERE email='$email' LIMIT 1"
        );

        if (mysqli_num_rows($check)) {

            $message = "This email already exists.";

        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users
                    (full_name, email, password, role)
                    VALUES
                    ('$name', '$email', '$hashed_password', 'student')";

            if (mysqli_query($connection, $sql)) {

                $message = "Student added successfully.";

            } else {

                $message = "Student was not added.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>

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
            left: 0;
            top: 0;
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
            background: #685e5e !important;
            margin-top: 25px !important;
        }

        .main {
            margin-left: 200px;
            padding: 30px;
            min-height: 100vh;
        }

        .box {
            background: white;
            width: 500px;
            padding: 25px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .box h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background: #00a884;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 3px;
            width: 100%;
        }

        button:hover {
            background: #008f70;
        }

        .message {
            background: #d9ffd6;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 3px;
        }

        @media (max-width: 700px) {

            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
            }

            .box {
                width: 100%;
            }
        }

    </style>

</head>

<body>

<div class="sidebar">
    <h2>Admin</h2>

    <a href="admin dashboard.php">Dashboard</a>

    <a href="add student.php">Add Student</a>

    <a href="attendance.php">Attendance</a>

    <a href="logout.php" class="logout">Logout</a>
</div>


<div class="main">

    <h1>Add Student</h1>

    <div class="box">

        <h2>Student Information</h2>

        <?php
        if ($message != "") {
            echo "<div class='message'>$message</div>";
        }
        ?>

        <form method="POST">

            <label>Full Name</label>

            <input
                type="text"
                name="name"
                placeholder="Enter full name"
                required
            >

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Enter student email"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Create student password"
                required
            >

            <button type="submit" name="add_student">
                Add Student
            </button>

        </form>

    </div>

</div>

</body>

</html>
```

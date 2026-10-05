
<?php

include ('CONNECTION.PHP');

session_start();

if (isset($_POST['register'])){
    $full_name =$_POST['name'];
    $email =$_POST['email'];
    $password =$_POST['password'];
    


    if ($full_name == "") {
        echo "Fill name";
    } elseif ($email == "") {
        echo "Fill email";
    } elseif ($password == "") {
        echo "Fill password";
    } elseif (strlen($password) < 8) {
        echo "Weak password";
    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (full_name, email,  password)
                VALUES (  '$full_name','$email', '$hashed_password')";

        $query = mysqli_query($connection, $sql);

        if ($query) {
            echo "Registration successful";
        } else {
            echo "Registration failed: " . mysqli_error($connection);
        }
 }
   }


if (isset($_POST['login'])) {

    $email = $_POST['email'];

    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";

    $query = mysqli_query($connection, $sql);

    if (mysqli_num_rows($query)) {

        $user = mysqli_fetch_assoc($query);

        if (password_verify($password, $user['password'])) {

           $_SESSION['role'] = $user['role'];
$_SESSION['full_name'] = $user['full_name'];
$_SESSION['email'] = $user['email'];
$_SESSION['user_id'] = $user['user_id']; 

            if ($user['role'] == 'admin') {

                header("Location: admin dashboard.php");

                exit();

            } elseif ($user['role'] == 'student') {

                header("Location: student dashboard.php");

                exit();

            } else {

                echo "Role is not correct.";

            }

        } else {

            echo "Email or password is incorrect";

        }

    } else {

        echo "Email or password is incorrect";

    }

}


?>



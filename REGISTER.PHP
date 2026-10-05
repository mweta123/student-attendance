<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <style>
        body {
            background-image: url(1.jpeg);
             background-size: cover;
              background-position: center;
              background-repeat: no-repeat;
        }
        

        #form-component {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
        }

        #form {
            background-color: azure;
            border-radius: 40px;
            opacity: 90%;
            padding: 20px;
            width: 400px;
        }

        #form-group {
            padding: 20px;
        }

        
        .input-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        label {
            color: blue;
            font-size: medium;
            margin-bottom: 15px;
        }

        input {
            padding: 5px;
            border: 1px solid grey;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: blue;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login{background-color: blue;
        padding: 5px;
        border-radius: 3px;
        margin-left: 5px;
        text-decoration: none;
        

        }
       .login:hover{
      background-color:red;
      cursor: pointer;
      text-decoration: none;
}

    </style>
</head>
<body>

    <div id="form-component">

        <form id="form" action="ACTION.PHP" method="POST">

            <h1>Student Attendance System</h1>
            <h2>Register to get started</h2>

            <div id="form-group">

                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <button type="submit" name="register" id="button">
                    Register
                </button>
                <p id="para"></p>
            </div> 
               
            <p>Already have an account?</p>
<a href="LOGIN.PHP" class="login">Login</a>
        </form>

    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>

    <style>
        body {
            background-image: url(1.jpeg);
            background-size: cover;
            background-position: centzer;
             background-repeat: no-repeat;

        }

        #form-component {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        #form {
            background-color: azure;
            border-radius: 40px;
            opacity: 60%;
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
            margin-bottom: 5px;
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
    </style>
</head>

<body>

    <div id="form-component">

        <form id="form" action="ACTION.PHP" method="POST">

            <h1>welcome !</h1>
            <h2>Login to get your Account</h2>

            <div id="form-group">


                <div class="input-group">
                    <label for="email">email</label>
                    <input type="varchar" name="email" id="email">
                </div>


                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <button type="submit" name="login" id="button">
                    login
                </button>
                <p id="para"></p>
            </div> 
               
        </form>

    </div>

</body>
</html>
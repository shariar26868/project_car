<?php
session_start();

// Include your database connection code here
require_once('DBconnect.php');

// Define variables to hold error messages
$errorMessage = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (isset($_POST['Driver_ID']) && isset($_POST['password'])) {
        $u = mysqli_real_escape_string($conn, $_POST['Driver_ID']);
        $p = mysqli_real_escape_string($conn, $_POST['password']);

        // Write the query to check if the username and password exist in the database
        $sql = "SELECT driver_id FROM driver WHERE name = '$u' AND password = '$p'";
        $result = mysqli_query($conn, $sql);

        // Check if the query returns a non-empty result set
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the driver_id
            $row = mysqli_fetch_assoc($result);
            $driver_id = $row['driver_id'];

            // Set the session variable
            $_SESSION['driver_id'] = $driver_id;

            // Redirect to the profile page upon successful login with driver_id parameter
            header("Location: profile.php?driver_id=" . $driver_id);
            exit();
        } else {
            // Display an error message if the username or password is incorrect
            $errorMessage = "Username or Password is wrong";
        }
    } else {
        // Display an error message if the required fields are not set
        $errorMessage = "Please enter both username and password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver's Login</title>
    <style>
        body {
            background-color: rgb(236, 165, 11);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: flex-start; /* Align text to the top left */
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: rgb(236, 165, 11);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin-top: 50px; /* Adjust the margin to center the login box vertically */
        }

        .connection-message {
            color: yellow;
        }

        .error-message {
            color: red;
            margin-top: 10px; /* Add space between login box and error message */
        }

        .login-title {
            color: #fff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .form-input {
            margin: 10px 0;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-button {
            background-color: #fff;
            color: rgb(236, 165, 11);
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .login-button:hover {
            background-color: rgb(236, 165, 11);
            color: #fff;
        }
    </style>
</head>
<body>

<div class="login-container">
    <?php
    // Display connection message if present
    if (!empty($errorMessage)) {
        echo '<div class="connection-message">' . $errorMessage . '</div>';
    }
    ?>
    <div class="login-title">Driver's Login</div>
    <form action="login.php" class="login-form" method="post">
        Username: <input type="text" class="form-input" name="Driver_ID" placeholder="Please enter username" required> <br/>
        Password: <input type="password" class="form-input" name="password" placeholder="Enter the Password" required> <br/>
        <input type="submit" value="Log in" class="login-button">
    </form>
</div>

</body>
</html>

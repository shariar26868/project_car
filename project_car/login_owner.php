<?php
// Include your database connection code here
require_once('DBconnect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (isset($_POST['name']) && isset($_POST['password'])) {
        // Sanitize and escape input data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Write the query to check if the name and password exist in the database
        $sql = "SELECT parking_owner_id FROM parkingowner WHERE name = '$name' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        // Check if the query returns a non-empty result set
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the parking_owner_id
            $row = mysqli_fetch_assoc($result);
            $parking_owner_id = $row['parking_owner_id'];

            // Redirect to the parking lot page with parking_owner_id parameter
            header("Location: parkinglot.php?parking_owner_id=" . $parking_owner_id);
            exit();
        } else {
            // Display an error message if the name or password is incorrect
            echo "Name or Password is wrong";
        }
    } else {
        // Display an error message if the required fields are not set
        echo "Please enter both name and password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Owner's Login</title>
    <style>
        body {
            background-color: rgb(236, 165, 11);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
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
    <div class="login-title">Parking Owner's Login</div>
    <form action="login_owner.php" class="login-form" method="post">
        Name: <input type="text" class="form-input" name="name" placeholder="Please enter name" required> <br/>
        Password: <input type="password" class="form-input" name="password" placeholder="Enter the Password" required> <br/>
        <input type="submit" class="login-button" value="Log in">
    </form>
</div>

</body>
</html>

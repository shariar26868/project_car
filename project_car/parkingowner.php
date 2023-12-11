<?php
// Include your database connection code here
require_once('DBconnect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (
        isset($_POST['name']) &&
        isset($_POST['email']) &&
        isset($_POST['phone_number']) &&
        isset($_POST['address']) &&
        isset($_POST['password'])
    ) {
        // Sanitize and escape input data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Write the query to insert data into the parkingowner table
        $sql = "INSERT INTO parkingowner(name, email, phone_number, address, password) 
                VALUES ('$name', '$email', '$phone_number', '$address', '$password')";

        // Execute the query
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect to the parking lot page
            header("Location: parkinglot.php");
            exit();
        } else {
            // Display an error message if the query fails
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Display an error message if the required fields are not set
        echo "Please fill out all the fields";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Owner Registration</title>
    <style>
        body {
            background-color: rgb(236, 165, 11);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .registration-container {
            background-color: rgb(236, 165, 11); /* Yellow background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .registration-title {
            color: #fff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .registration-form {
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

        .register-button {
            background-color: #fff;
            color: rgb(236, 165, 11); /* Yellow text */
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .register-button:hover {
            background-color: rgb(236, 165, 11); /* Yellow background on hover */
            color: #fff;
        }
    </style>
</head>
<body>

<div class="registration-container">
    <div class="registration-title">Parking Owner Registration</div>
    <form action="parkingowner.php" class="registration-form" method="post">
        Name: <input type="text" class="form-input" name="name" placeholder="Enter your name" required> <br/>
        Email: <input type="email" class="form-input" name="email" placeholder="Enter your email" required> <br/>
        Phone Number: <input type="text" class="form-input" name="phone_number" placeholder="Enter your phone number" required> <br/>
        Address: <textarea class="form-input" name="address" placeholder="Enter your address" required></textarea> <br/>
        Password: <input type="password" class="form-input" name="password" placeholder="Enter your password" required> <br/>
        <input type="submit" value="Register" class="register-button">
    </form>
</div>

</body>
</html>

<?php
// Include your database connection code here
include('DBconnect.php');

// Initialize variables to hold registration data and error message
$name = $email = $phone_number = $license_number = $password = '';
$error_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $license_number = $_POST['license_number'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate form data (add more validation as needed)
    if (empty($name) || empty($email) || empty($phone_number) || empty($license_number) || empty($password)) {
        $error_message = 'All fields are required.';
    } else {
        

        // Insert the new driver into the database
        $sql = "INSERT INTO Driver (name, email, phone_number, license_number, password) 
                VALUES ('$name', '$email', '$phone_number', '$license_number', '$password')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect to the login page after successful registration
            header("Location: login.php");
            exit();
        } else {
            $error_message = 'Registration failed. Please try again later.';
        }
    }
}

// Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Registration</title>
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

<div class="registration-container">
    <h2>Driver Registration</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="registration-form">
        <input type="text" class="form-input" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
        <input type="text" class="form-input" name="email" placeholder="Email" value="<?php echo $email; ?>" required>
        <input type="text" class="form-input" name="phone_number" placeholder="Phone Number" value="<?php echo $phone_number; ?>" required>
        <input type="text" class="form-input" name="license_number" placeholder="License Number" value="<?php echo $license_number; ?>" required>
        <input type="password" class="form-input" name="password" placeholder="Password" required>
        <input type="submit" class="register-button" value="Register">
    </form>

    <?php
    if (!empty($error_message)) {
        echo '<div class="error-message">' . $error_message . '</div>';
    }
    ?>
</div>

</body>
</html>

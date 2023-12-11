



<?php
// Assuming you have already started the session
session_start();

// Check if the driver is logged in, redirect to the login page if not
if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection code here
require_once('DBconnect.php');

// Fetch driver details from the database using the driver_id from the session
$driver_id = $_SESSION['driver_id'];

// Validate driver_id (optional but recommended)
if (!is_numeric($driver_id)) {
    die("Invalid driver ID");
}

// Fetch driver details
$sql = "SELECT * FROM driver WHERE driver_id = $driver_id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching driver details: " . mysqli_error($conn));
}

$driver = mysqli_fetch_assoc($result);

// Check if the form to add a car is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_car'])) {
    $license_plate_number = mysqli_real_escape_string($conn, $_POST['license_plate_number']);
    $model = mysqli_real_escape_string($conn, $_POST['model']);
    $registration_year = mysqli_real_escape_string($conn, $_POST['registration_year']);

    // Insert the car details into the car table
    $insertCarSql = "INSERT INTO car (driver_id, license_plate_number, model, registration_year) 
                     VALUES ($driver_id, '$license_plate_number', '$model', '$registration_year')";
    
    $insertCarResult = mysqli_query($conn, $insertCarSql);

    if ($insertCarResult) {
        // Redirect back to the profile page after successfully adding the car
        header("Location: profile.php");
        exit();
    } else {
        die("Error adding car: " . mysqli_error($conn));
    }
}

// Fetch car details if the driver has a car
$sqlCar = "SELECT * FROM car WHERE driver_id = $driver_id";
$resultCar = mysqli_query($conn, $sqlCar);

if (!$resultCar) {
    die("Error checking car details: " . mysqli_error($conn));
}

$hasCar = mysqli_num_rows($resultCar) > 0;

// Fetch car details if the driver has a car
if ($hasCar) {
    $car = mysqli_fetch_assoc($resultCar);
}

// Check if the form to delete a car is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_car'])) {
    // Delete the car from the database
    $deleteCarSql = "DELETE FROM car WHERE driver_id = $driver_id";
    $deleteCarResult = mysqli_query($conn, $deleteCarSql);

    if ($deleteCarResult) {
        // Redirect back to the profile page after successfully deleting the car
        header("Location: profile.php");
        exit();
    } else {
        die("Error deleting car: " . mysqli_error($conn));
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver's Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(236, 165, 11); /* Yellow background */
        }

        .profile-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .welcome-message {
            font-size: 24px;
            margin-bottom: 20px;
            color: rgb(236, 165, 11); /* Yellow text */
        }

        .details-container {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .details-label {
            font-weight: bold;
            text-decoration: underline;
            margin-right: 10px;
        }

        .details-info {
            font-style: italic;
            color: rgb(236, 165, 11); /* Yellow text */
            font-size: 18px;
            display: inline; /* Display on the same line */
        }

        .options-container {
            display: flex;
            justify-content: space-between;
        }

        .options-button {
            background-color: rgb(236, 165, 11); /* Yellow button */
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .options-button:hover {
            background-color: #e6830b; /* Darker shade on hover */
        }

        .car-details-container {
            margin-bottom: 20px;
            font-size: 18px;
        }

        .car-details-label {
            font-weight: bold;
            text-decoration: underline;
            margin-right: 10px;
        }

        .car-details-info {
            font-style: italic;
            color: rgb(236, 165, 11); /* Yellow text */
            font-size: 18px;
            display: inline; /* Display on the same line */
        }

        .delete-car-button {
            background-color: red;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .delete-car-button:hover {
            background-color: darkred; /* Darker shade on hover */
        }

        .car-details-box {
            background-color: #eee;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="welcome-message">Welcome, <?php echo $driver['name']; ?>!</div>


<div class="details-container">
    <div class="details-label">Name:</div>
    <div class="details-info"><?php echo $driver['name']; ?></div>
</div>

<div class="details-container">
    <div class="details-label">Email:</div>
    <div class="details-info"><?php echo $driver['email']; ?></div>
</div>

<div class="details-container">
    <div class="details-label">Phone Number:</div>
    <div class="details-info"><?php echo $driver['phone_number']; ?></div>
</div>

<div class="details-container">
    <div class="details-label">License Number:</div>
    <div class="details-info"><?php echo $driver['license_number']; ?></div>
</div>

<div class="options-container">
    <a href="book_parking_spot.php" class="options-button">Book a Parking Spot</a>
    <a href="review.php" class="options-button">Review</a>
</div>
</div>

    <?php if ($hasCar) { ?>
        <div class="car-details-box">
            <div class="car-details-label">Car Details:</div>
            <div class="car-details-info">
                <p><strong>Model:</strong> <?php echo $car['model']; ?></p>
                <p><strong>Registration Year:</strong> <?php echo $car['registration_year']; ?></p>
                <p><strong>License Plate Number:</strong> <?php echo $car['license_plate_number']; ?></p>
            </div>
            <form action="profile.php" method="post">
                <input type="submit" name="delete_car" class="delete-car-button" value="Delete Car">
            </form>
        </div>
    <?php } else { ?>
        <div class="car-details-container">
            <h3>Add Car Details:</h3>
            <!-- Form to add a new car -->
            <form action="profile.php" method="post">
                <input type="text" name="license_plate_number" placeholder="License Plate Number" required>
                <input type="text" name="model" placeholder="Model" required>
                <input type="text" name="registration_year" placeholder="Registration Year" required>
                <input type="submit" name="add_car" class="options-button" value="Add Car">
            </form>
        </div>
    <?php } ?>

</div>

</body>
</html>

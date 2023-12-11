<?php
// Start the session after the driver logs in
session_start();

// Check if the driver is logged in, redirect to the login page if not
if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection code here
require_once('DBconnect.php');

// Fetch driver details using the driver_id from the session
$driver_id = $_SESSION['driver_id'];
$sqlDriver = "SELECT * FROM driver WHERE driver_id = $driver_id";
$resultDriver = mysqli_query($conn, $sqlDriver);

if (!$resultDriver) {
    die("Error fetching driver details: " . mysqli_error($conn));
}

$driver = mysqli_fetch_assoc($resultDriver);

// Fetch parking space details using the parking_lot_id from the URL parameter
$parking_lot_id = $_GET['parking_lot_id'] ?? null;

if (!$parking_lot_id) {
    // Redirect to the book parking spot page if parking_lot_id is not provided
    header("Location: book_parking_spot.php");
    exit();
}

$sqlParkingLot = "SELECT * FROM parkinglot WHERE parking_lot_id = $parking_lot_id";
$resultParkingLot = mysqli_query($conn, $sqlParkingLot);

if (!$resultParkingLot) {
    die("Error fetching parking lot details: " . mysqli_error($conn));
}

$parkingLot = mysqli_fetch_assoc($resultParkingLot);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (isset($_POST['start_time']) && isset($_POST['end_time'])) {
        // Sanitize and escape input data
        $start_time = mysqli_real_escape_string($conn, $_POST['start_time']);
        $end_time = mysqli_real_escape_string($conn, $_POST['end_time']);

        // Fetch the car_id of the driver
        $sqlCarID = "SELECT car_id FROM car WHERE driver_id = $driver_id";
        $resultCarID = mysqli_query($conn, $sqlCarID);

        if (!$resultCarID) {
            die("Error fetching car ID: " . mysqli_error($conn));
        }

        $carID = mysqli_fetch_assoc($resultCarID)['car_id'];

        // Write the query to insert the booking data into the database
        $insertQuery = "INSERT INTO booking (assigned_driver_id, car_id, parking_lot_id, start_time, end_time)
                        VALUES ('$driver_id', '$carID', '$parking_lot_id', '$start_time', '$end_time')";

        $insertResult = mysqli_query($conn, $insertQuery);

        if (!$insertResult) {
            die("Error inserting booking data: " . mysqli_error($conn));
        }

        // Fetch the booking ID from the database
        $bookingID = mysqli_insert_id($conn);

        // Store driver_id and booking_id in session
        $_SESSION['driver_id'] = $driver_id;
        $_SESSION['booking_id'] = $bookingID;

        // Redirect to the process payment page with the booking ID parameter
        header("Location: process_payment.php?booking_id=$bookingID");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(236, 165, 11); /* Yellow background */
        }

        .booking-details-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .details-label {
            font-weight: bold;
            margin-right: 10px;
            color: #333; /* Dark text color */
        }

        .details-value {
            font-size: 18px;
            color: rgb(236, 165, 11);
        }

        .time-selection-container {
            margin-top: 20px;
        }

        .time-label {
            font-weight: bold;
            margin-right: 10px;
            color: #333; /* Dark text color */
        }

        .time-input {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc; /* Light border color */
        }

        .proceed-button {
            background-color: rgb(236, 165, 11); /* Yellow button */
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .proceed-button:hover {
            background-color: #e5b200; /* Darker yellow on hover */
        }
    </style>
</head>
<body>

<div class="booking-details-container">
    <h2>Booking Details</h2>

    <div>
        <span class="details-label">Driver Name:</span>
        <span class="details-value"><?php echo $driver['name']; ?></span>
    </div>

    <div>
        <span class="details-label">Parking Lot ID:</span>
        <span class="details-value"><?php echo $parkingLot['parking_lot_id']; ?></span>
    </div>

    <div>
        <span class="details-label">Parking Lot Address:</span>
        <span class="details-value"><?php echo $parkingLot['address']; ?></span>
    </div>

    <div class="time-selection-container">
        <h3>Select Booking Time</h3>
        <form action="process_booking.php?parking_lot_id=<?php echo $parking_lot_id; ?>" method="post">
            <!-- Add hidden fields for driver_id and booking_id -->
            <input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>">
            <input type="hidden" name="booking_id" value="<?php echo $bookingID; ?>">
            <label class="time-label" for="start_time">Start Time:</label>
            <input class="time-input" type="datetime-local" name="start_time" required><br>

            <label class="time-label" for="end_time">End Time:</label>
            <input class="time-input" type="datetime-local" name="end_time" required><br>

            <input type="submit" class="proceed-button" value="Proceed to Payment">
        </form>
    </div>
</div>

</body>
</html>

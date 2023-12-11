<?php
// Assuming you have already started the session after the driver logs in
session_start();

// Check if the driver is logged in, redirect to the login page if not
if (!isset($_SESSION['driver_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection code here
require_once('DBconnect.php');

// Fetch available parking lots for booking
$sql = "SELECT * FROM ParkingLot WHERE space_availability > 0";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching available parking lots: " . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Parking Spot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(236, 165, 11);
            color: rgb(236, 165, 11);
        }

        .booking-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: rgb(236, 165, 11);
        }

        .available-spots-container {
            margin-bottom: 20px;
        }

        .available-spots-label {
            font-weight: bold;
            margin-right: 10px;
        }

        .parking-lot {
            margin-bottom: 10px;
        }

        .book-button {
            background-color: #fff;
            color: rgb(236, 165, 11);
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .book-button:hover {
            background-color: rgb(236, 165, 11);
            color: #fff;
        }
    </style>
</head>
<body>

<div class="booking-container">
    <h2>Book a Parking Spot</h2>

    <div class="available-spots-container">
        <div class="available-spots-label">Available Parking Spots:</div>

        <?php
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="parking-lot">';
    echo 'Parking Lot ID: ' . $row['parking_lot_id'] . '<br>';
    echo 'Address: ' . $row['address'] . '<br>';
    echo 'Capacity: ' . $row['capacity'] . '<br>';
    echo 'Space Availability: ' . $row['space_availability'] . '<br>';
    echo '<a href="process_booking.php?parking_lot_id=' . $row['parking_lot_id'] . '&driver_id=' . $_SESSION['driver_id'] . '" class="book-button">Book</a>';
    echo '</div>';
}
?>
    </div>
</div>

</body>
</html>

<?php
session_start();

// Include your database connection code here
require_once('DBconnect.php');

// Check if the driver is logged in and has a booking ID
if (!isset($_SESSION['driver_id']) || !isset($_SESSION['booking_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch driver details using the driver_id from the session
$driver_id = $_SESSION['driver_id'];
$sqlDriver = "SELECT * FROM driver WHERE driver_id = $driver_id";
$resultDriver = mysqli_query($conn, $sqlDriver);

if (!$resultDriver) {
    die("Error fetching driver details: " . mysqli_error($conn));
}

$driver = mysqli_fetch_assoc($resultDriver);

// Fetch booking details using the booking_id from the session
$booking_id = $_SESSION['booking_id'];
$sqlBooking = "SELECT * FROM booking WHERE booking_id = $booking_id";
$resultBooking = mysqli_query($conn, $sqlBooking);

if (!$resultBooking) {
    die("Error fetching booking details: " . mysqli_error($conn));
}

$booking = mysqli_fetch_assoc($resultBooking);

// Fetch parking lot details using the parking_lot_id from the booking table
$parking_lot_id = $booking['parking_lot_id'];
$sqlParkingLot = "SELECT * FROM parkinglot WHERE parking_lot_id = $parking_lot_id";
$resultParkingLot = mysqli_query($conn, $sqlParkingLot);

if (!$resultParkingLot) {
    die("Error fetching parking lot details: " . mysqli_error($conn));
}

$parkingLot = mysqli_fetch_assoc($resultParkingLot);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);
    $rating = (int)$_POST['rating'];
    $date_submitted = date('Y-m-d');

    // Insert review data into the review table
    $insertReviewQuery = "INSERT INTO review (driver_id, parking_lot_id, rating, review_text, date_submitted)
                        VALUES ('$driver_id', '$parking_lot_id', '$rating', '$review_text', '$date_submitted')";
    
    $insertReviewResult = mysqli_query($conn, $insertReviewQuery);

    if ($insertReviewResult) {
        // Redirect to the home.php page after successful submission
        header("Location: home.php");
        exit();
    } else {
        die("Error inserting review data: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: rgb(236, 165, 11);
            color: white;
        }

        .review-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: rgb(236, 165, 11);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .review-box,
        .rating-box {
            margin-bottom: 20px;
        }

        label {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        textarea,
        input[type="range"] {
            width: 100%;
            padding: 10px;
            border: 1px solid rgb(236, 165, 11);
            border-radius: 5px;
            margin-bottom: 10px;
        }

        input[type="range"] {
            cursor: pointer;
        }

        #rating-display {
            font-size: 1.2em;
            color: rgb(236, 165, 11);
            margin-top: -10px; /* Adjust the margin for better visibility */
        }

        input[type="submit"] {
            background-color: rgb(236, 165, 11);
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
        }

        input[type="submit"]:hover {
            background-color: rgba(236, 165, 11, 0.8);
        }
    </style>
</head>



<body>
<div class="review-container">
    <h2>Review Your Experience</h2>
    <form action="" method="post">
        <div class="review-box">
            <label for="review_text">Write your review:</label>
            <textarea id="review_text" name="review_text" rows="4" cols="50" required></textarea>
        </div>
        <div class="rating-box">
            <label for="rating">Rate your experience:</label>
            <input type="range" id="rating" name="rating" min="1" max="5" value="5" required>
            <p id="rating-display">5 stars</p>
        </div>

        <input type="submit" value="Submit Review">
    </form>
</div>
<script>
    // Update the displayed rating value when the range input changes
    document.getElementById('rating').addEventListener('input', function() {
        document.getElementById('rating-display').textContent = this.value + ' stars';
    });
</script>

</body>
</html>

<?php
session_start();

// Include your database connection code here
require_once('DBconnect.php');

// Check if the driver is logged in, redirect to the login page if not
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

// Calculate payment amount
$start_time = strtotime($booking['start_time']);
$end_time = strtotime($booking['end_time']);
$current_time = time();
$time_difference = ceil(($end_time - $start_time) / 3600); // Calculate time difference from current time to end time in hours
$payment_amount = 50 * $time_difference;


// Insert payment details into the payment table
$payment_method = $_POST['payment_method'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $payment_method) {
    $payment_date = date('Y-m-d');
    $insertPaymentQuery = "INSERT INTO payment (booking_id, payment_method, payment_amount, payment_date)
                            VALUES ('$booking_id', '$payment_method', '$payment_amount', '$payment_date')";

    $insertPaymentResult = mysqli_query($conn, $insertPaymentQuery);

    if ($insertPaymentResult) {
        // Redirect to the appropriate page based on the payment method
        if ($payment_method === 'online') {
            header("Location: https://www.bkash.com");
        } else {
            header("Location: thankyou.php");
        }
        exit();
    } else {
        die("Error inserting payment data: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: rgb(236, 165, 11); /* Yellow background */
        color: rgb(236, 165, 11); /* Yellow text color */
    }

    .payment-details-container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff; /* White background */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .details-box {
        margin-bottom: 20px;
    }

    h2, h3 {
        color: rgb(236, 165, 11); /* Yellow text color for headings */
    }

    .details-box p {
        margin: 10px 0;
    }

    .payment-method-container {
        margin-top: 20px;
    }

    label {
        color: rgb(236, 165, 11); /* Yellow text color for labels */
        margin-right: 10px;
    }

    input[type="radio"] {
        margin-right: 5px;
    }

    .pay-button {
        background-color: rgb(236, 165, 11); /* Yellow button */
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .pay-button:hover {
        background-color: #e5b200; /* Darker yellow on hover */
    }
</style>

</head>

<body>
<div class="payment-details-container">
    <h2>Payment Details</h2>

    <div class="details-box">
        <h3>Driver Details</h3>
        <p><strong>Name:</strong> <?php echo $driver['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $driver['email']; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $driver['phone_number']; ?></p>
        <p><strong>License Number:</strong> <?php echo $driver['license_number']; ?></p>
    </div>

    <div class="details-box">
        <h3>Parking Lot Details</h3>
        <p><strong>Space:</strong> <?php echo $parkingLot['space_availability']; ?></p>
        <p><strong>Address:</strong> <?php echo $parkingLot['address']; ?></p>
        <p><strong>Capacity:</strong> <?php echo $parkingLot['capacity']; ?></p>
    </div>

    <div class="details-box">
        <h3>Payment Amount</h3>
        <p><strong>Amount:</strong> <?php echo $payment_amount; ?></p>
    </div>

    <div class="payment-method-container">
        <h3>Select Payment Method</h3>
        <form action="" method="post">
            <label for="online_payment">Online Payment</label>
            <input type="radio" id="online_payment" name="payment_method" value="online" required>

            <label for="cash_payment">Cash</label>
            <input type="radio" id="cash_payment" name="payment_method" value="cash" required>

            <input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
    
            <input type="submit" class="pay-button" value="Pay">
        </form>
    </div>
</div>
</body>
</html>

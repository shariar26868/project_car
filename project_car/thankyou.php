<?php
session_start();

// Check if driver_id and booking_id are set in the session
if (!isset($_SESSION['driver_id']) || !isset($_SESSION['booking_id'])) {
    // Redirect to home.php if the session variables are not set
    header("Location: home.php");
    exit();
}

// Function to generate a random review ID for demonstration purposes
function generateReviewID() {
    return rand(1000, 9999);
}

// Set driver_id and booking_id from the session
$driver_id = $_SESSION['driver_id'];
$booking_id = $_SESSION['booking_id'];

// If the user clicks the "review" button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review'])) {
    // Redirect to review.php and pass driver_id and booking_id as parameters
    $review_id = generateReviewID(); // Generate a random review ID
    header("Location: review.php?driver_id=$driver_id&booking_id=$booking_id&review_id=$review_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            background-color: rgb(236, 165, 11);
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 3em;
        }

        .message {
            margin-top: 2em;
            margin-bottom: 3em;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }

        .button {
            margin: 0 1em;
            padding: 1em 2em;
            font-size: 1em;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: white;
            color: rgb(236, 165, 11);
        }
    </style>
</head>
<body>
    <h1>Thank You for using MyParkingSpot website</h1>

    <div class="message">
        <p>Would you like to leave us a review?</p>
    </div>

    <div class="button-container">
        <form method="post">
            <!-- Submit the form with the "review" button -->
            <button class="button" type="submit" name="review">Review</button>
        </form>
        <a href="home.php" class="button">Home</a>
    </div>
</body>
</html>

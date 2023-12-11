<?php
// Include your database connection code here
require_once('DBconnect.php');

// Check if the parking_owner_id is set in the URL
if (!isset($_GET['parking_owner_id'])) {
    // Redirect to the parking owner's login page if parking_owner_id is not set
    header("Location: login_owner.php");
    exit();
}

$parking_owner_id = $_GET['parking_owner_id'];

// Check if the form to add a new parking lot is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required fields are set
    if (isset($_POST['newAddress']) && isset($_POST['newCapacity']) && isset($_POST['newSpaceAvailability'])) {
        // Sanitize and escape input data
        $newAddress = mysqli_real_escape_string($conn, $_POST['newAddress']);
        $newCapacity = mysqli_real_escape_string($conn, $_POST['newCapacity']);
        $newSpaceAvailability = mysqli_real_escape_string($conn, $_POST['newSpaceAvailability']);

        // Write the query to insert the new parking lot data into the database
        $insertQuery = "INSERT INTO parkinglot (address, capacity, space_availability, parking_owner_id)
                        VALUES ('$newAddress', '$newCapacity', '$newSpaceAvailability', '$parking_owner_id')";

        $insertResult = mysqli_query($conn, $insertQuery);

        if (!$insertResult) {
            die("Error inserting new parking lot data: " . mysqli_error($conn));
        }

        // Refresh the page to display the updated information
        header("Location: parkinglot.php?parking_owner_id=" . $parking_owner_id);
        exit();
    }
}

// Delete parking lot if delete button is clicked
if (isset($_GET['delete_parking_lot_id'])) {
    $delete_parking_lot_id = $_GET['delete_parking_lot_id'];

    // Write the query to delete the parking lot data from the database
    $deleteQuery = "DELETE FROM parkinglot WHERE parking_lot_id = '$delete_parking_lot_id'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if (!$deleteResult) {
        die("Error deleting parking lot data: " . mysqli_error($conn));
    }

    // Refresh the page to reflect the deletion
    header("Location: parkinglot.php?parking_owner_id=" . $parking_owner_id);
    exit();
}

// Fetch all parking lot details from the database using parking_owner_id
$sql = "SELECT * FROM parkinglot WHERE parking_owner_id = $parking_owner_id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching parking lot details: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Lot Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(236, 165, 11);
        }

        .parking-lot-container {
            display: flex;
            justify-content: space-between;
            margin: 20px;
        }

        .parking-lot-details,
        .add-parking-lot-form {
            width: 45%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: rgb(236, 165, 11);
        }

        strong {
            font-weight: bold;
        }

        .existing-info {
            font-size: 18px;
            color: rgb(236, 165, 11);
            font-style: italic;
        }

        hr {
            border: 1px solid #ccc;
            margin: 10px 0;
        }

        .add-parking-lot-form form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: rgb(236, 165, 11);
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #ffcc00;
            color: #333;
        }

        .delete-button {
            background-color: #ff0000; /* Red button */
            color: #fff;
            border: none;
            padding: 5px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-button:hover {
            background-color: #cc0000; /* Darker red on hover */
        }
    </style>
</head>
<body>

<div class="parking-lot-container">
    <div class="parking-lot-details">
        <h2>Parking Lot Details</h2>
        <?php
        // Display existing parking lots
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div><strong>Address:</strong> <span class='existing-info'>{$row['address']}</span></div>";
            echo "<div><strong>Capacity:</strong> <span class='existing-info'>{$row['capacity']}</span></div>";
            echo "<div><strong>Space Availability:</strong> <span class='existing-info'>{$row['space_availability']}</span></div>";
            echo "<div><strong>Parking Lot ID:</strong> <span class='existing-info'>{$row['parking_lot_id']}</span></div>";

            // Delete button for each parking lot
            echo "<a class='delete-button' href='?parking_owner_id=$parking_owner_id&delete_parking_lot_id={$row['parking_lot_id']}'>Delete</a>";

            echo "<hr>";
        }
        ?>
    </div>

    <div class="add-parking-lot-form">
    <h2>Add New Parking Lot</h2>
        <form action="parkinglot.php?parking_owner_id=<?php echo $parking_owner_id; ?>" method="post">
            Address: <input type="text" name="newAddress" required><br>
            Capacity: <input type="number" name="newCapacity" required><br>
            Space Availability: <input type="number" name="newSpaceAvailability" required><br>
            <input type="submit" value="Add Parking Lot">
        </form>
    </div>
</div>


</body>
</html>

<?php
session_start();
include '../dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: log-in.html");
    exit();
}

$customer_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM vansched WHERE customer_id = $customer_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .booking-container { margin: 20px auto; width: 60%; }
        .book-btn { background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border: none; cursor: pointer; border-radius: 5px; }
        .book-btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <h2>My Bookings</h2>
    <div class="booking-container">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <p><?php echo "{$row['pickup_location']} to {$row['dropoff_location']} - {$row['departure_time']}"; ?></p>
        <?php } ?>
    </div>

    <a href="bookvan.php"><button class="book-btn">Book a Van</button></a>

</body>
</html>

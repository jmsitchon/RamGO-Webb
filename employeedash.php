<?php
include '../dbconnect.php';
session_start();


$sql = "SELECT * FROM vansched ORDER BY departure_time ASC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .set-ride { background-color: blue; color: white; padding: 10px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

<h2>Employee Dashboard - View Rides</h2>

<table>
    <tr>
        <th>Schedule ID</th>
        <th>Driver ID</th>
        <th>Departure</th>
        <th>Arrival</th>
        <th>Pickup</th>
        <th>Dropoff</th>
        <th>Fare</th>
        <th>Status</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['schedule_id']}</td>
                    <td>{$row['employee_id']}</td>
                    <td>{$row['departure_time']}</td>
                    <td>{$row['arrival_time']}</td>
                    <td>{$row['pickup_location']}</td>
                    <td>{$row['dropoff_location']}</td>
                    <td>₱{$row['fare']}</td>
                    <td>{$row['status']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No rides available.</td></tr>";
    }
    $conn->close();
    ?>
</table>

<!-- Button to Set a New Ride -->
<a href="setride.php" class="set-ride">Set a Ride</a>

</body>
</html>

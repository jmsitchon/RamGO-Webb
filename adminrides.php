<?php
include '../dbconnect.php';

$sql = "SELECT * FROM vansched ORDER BY departure_time ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Rides</title>
    <style>
        body {
            background-color: #112D7C;
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        h2 {
            color: #FFD700;
        }
        table {
            width: 90%;
            max-width: 1000px;
            border-collapse: collapse;
            background: white;
            color: black;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            border: 1px solid black;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #FFD700;
            color: black;
        }
        .approve, .decline, .delete {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .approve {
            background-color: green;
            color: white;
        }
        .decline {
            background-color: red;
            color: white;
        }
        .delete {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>

<h2>Admin Panel - Manage Rides</h2>

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
        <th>Action</th>
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
                    <td id='status-{$row['schedule_id']}'>{$row['status']}</td>
                    <td id='action-{$row['schedule_id']}'>";
            
            if ($row['status'] === "cancelled") {
                echo "<button class='delete' onclick='deleteRide({$row["schedule_id"]})'>Delete</button>";
            } else {
                echo "<button class='approve' onclick='updateStatus({$row["schedule_id"]}, \"confirmed\")'>Approve</button>
                      <button class='decline' onclick='updateStatus({$row["schedule_id"]}, \"cancelled\")'>Decline</button>";
            }

            echo "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='9'>No rides available.</td></tr>";
    }
    $conn->close();
    ?>
</table>

<script>
function updateStatus(scheduleId, newStatus) {
    fetch('updateride.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `schedule_id=${scheduleId}&status=${newStatus}`
    })
    .then(response => response.text())
    .then(data => {
        if (data === "success") {
            document.getElementById('status-' + scheduleId).innerText = newStatus;
            if (newStatus === "cancelled") {
                document.getElementById('action-' + scheduleId).innerHTML = `<button class='delete' onclick='deleteRide(${scheduleId})'>Delete</button>`;
            }
            alert("Ride status updated successfully!");
        } else {
            alert("Error updating ride status.");
        }
    });
}

function deleteRide(scheduleId) {
    if (confirm("Are you sure you want to delete this ride?")) {
        fetch('delete.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `schedule_id=${scheduleId}`
        })
        .then(response => response.text())
        .then(data => {
            if (data === "success") {
                document.getElementById('status-' + scheduleId).innerText = "Deleted";
                document.getElementById('action-' + scheduleId).innerHTML = "<b>Deleted</b>";
                alert("Ride deleted successfully!");
            } else {
                alert("Error deleting ride.");
            }
        });
    }
}
</script>

</body>
</html>

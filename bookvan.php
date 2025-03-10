<form action="processbook.php" method="POST">
    <label for="schedule_id">Select Schedule:</label>
    <select name="schedule_id" required>
        <?php
        include '../dbconnect.php';
        $result = $conn->query("SELECT schedule_id, pickup_location, dropoff_location, departure_time FROM vansched WHERE status='confirmed' AND customer_id IS NULL");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['schedule_id']}'>
                    {$row['pickup_location']} to {$row['dropoff_location']} - {$row['departure_time']}
                  </option>";
        }
        ?>
    </select>
    <button type="submit">Book Now</button>
</form>

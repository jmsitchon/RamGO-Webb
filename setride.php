<form action="processride.php" method="POST">
    <input type="hidden" name="employee_id" value="<?php echo $_SESSION['employee_id']; ?>">
    
    <label>Departure Time:</label>
    <input type="datetime-local" name="departure_time" required><br>

    <label>Arrival Time:</label>
    <input type="datetime-local" name="arrival_time" required><br>

    <label for="station_code">Pickup Station:</label>
<select name="station_code" id="station_code" required onchange="updatePickupLocation()">
    <option value="SMB" data-location="SM Bicutan, Taguig City">SM Bicutan, Taguig City</option>
    <option value="PITX" data-location="Parañaque Integrated Terminal Exchange">Parañaque Integrated Terminal Exchange</option>
    <option value="SMC" data-location="SM Cubao">SM Cubao</option>
</select>
<br>

    <label>Dropoff Location:</label>
    <input type="text" name="dropoff_location" required><br>

    <label>Fare:</label>
    <input type="number" name="fare" step="0.01" required><br>

    <button type="submit">Set Ride</button>
</form>

<?php
include '../dbconnect.php';
session_start();

if (!isset($_SESSION['employee_id'])) {
    die("Error: Employee not logged in.");
}

$employee_id = $_SESSION['employee_id'];
$departure_time = $_POST['departure_time'];
$arrival_time = $_POST['arrival_time'];
$station_code = $_POST['station_code'];  // Now explicitly getting the station code
$dropoff_location = $_POST['dropoff_location'];
$fare = $_POST['fare'];

// Get the current datetime
date_default_timezone_set('Asia/Manila');
$current_datetime = date('Y-m-d H:i:s');

// Validate that departure_time and arrival_time are not in the past
if ($departure_time < $current_datetime || $arrival_time < $current_datetime) {
    echo "<script>alert('Error: Departure and arrival times cannot be in the past!'); window.history.back();</script>";
    exit();
}

// Validate that arrival_time is after departure_time
if ($arrival_time <= $departure_time) {
    echo "<script>alert('Error: Arrival time must be after departure time!'); window.history.back();</script>";
    exit();
}

// Ensure station_code is valid
$valid_stations = [
    'SMB' => 'SM Bicutan, Taguig City',
    'PITX' => 'Parañaque Integrated Terminal Exchange',
    'SMC' => 'SM Cubao'
];

if (!array_key_exists($station_code, $valid_stations)) {
    echo "<script>alert('Error: Invalid pickup station!'); window.history.back();</script>";
    exit();
}

// Ensure pickup_location matches the station_code's full name
$pickup_location = $valid_stations[$station_code];

// Ensure dropoff_location is fixed to 'Asia Pacific College'
if ($dropoff_location !== 'Asia Pacific College') {
    echo "<script>alert('Error: Dropoff location must be Asia Pacific College!'); window.history.back();</script>";
    exit();
}

// Insert into the database
$sql = "INSERT INTO vansched (employee_id, departure_time, arrival_time, station_code, pickup_location, dropoff_location, fare, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isssssd", $employee_id, $departure_time, $arrival_time, $station_code, $pickup_location, $dropoff_location, $fare);

if ($stmt->execute()) {
    echo "<script>alert('Ride set successfully!'); window.location.href='employeedash.php';</script>";
} else {
    echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>

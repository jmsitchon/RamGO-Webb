<?php
include '../dbconnect.php';
header('Content-Type: application/json');

$sql = "SELECT schedule_id, pickup_location, dropoff_location, departure_time FROM vansched WHERE status='confirmed' AND customer_id IS NULL";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["status" => "error", "message" => "SQL Error: " . $conn->error]);
    exit;
}

$schedules = [];
while ($row = $result->fetch_assoc()) {
    $schedules[] = $row;
}

if (!empty($schedules)) {
    echo json_encode(["status" => "success", "schedules" => $schedules]);
} else {
    echo json_encode(["status" => "error", "message" => "No schedules available"]);
}
?>

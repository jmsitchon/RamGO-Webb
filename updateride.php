<?php
include '../dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $schedule_id = $_POST['schedule_id'];
    $status = $_POST['status'];

    $sql = "UPDATE vansched SET status = ? WHERE schedule_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "error";
        exit();
    }

    $stmt->bind_param("si", $status, $schedule_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>

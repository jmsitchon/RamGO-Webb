<?php
include '../dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['schedule_id'])) {
    $schedule_id = $_POST['schedule_id'];

    $sql = "DELETE FROM vansched WHERE schedule_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $schedule_id);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
        $stmt->close();
    } else {
        echo "error";
    }
    
    $conn->close();
} else {
    echo "error";
}
?>

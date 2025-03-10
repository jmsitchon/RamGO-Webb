<?php
session_start();
include '../dbconnect.php';  // Ensure the correct path

// Check if the customer is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: ../log-in.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve schedule_id from POST data
    $schedule_id = isset($_POST['schedule_id']) ? trim($_POST['schedule_id']) : '';

    // Get the logged-in customer's email and user_id from session
    $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $user_id = $_SESSION['user_id'];  // Get customer ID from session

    // Validate schedule_id and user_email
    if (empty($schedule_id) || empty($user_email)) {
        echo json_encode(["status" => "error", "message" => "Invalid input data"]);
        exit();
    }

    // Check availability of schedule
    $check_sql = "SELECT * FROM vansched WHERE schedule_id = ? AND customer_id IS NULL";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $schedule_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Schedule available, proceed to booking
        $update_sql = "UPDATE vansched SET customer_id = ?, status = 'booked' WHERE schedule_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ii", $user_id, $schedule_id); // Use customer_id from session

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Booking successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Booking failed"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Schedule is no longer available"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>

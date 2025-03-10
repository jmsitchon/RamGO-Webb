<?php
include '../dbconnect.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    if (empty($email)) {
        echo json_encode(["status" => "error", "message" => "Email is required"]);
        exit();
    }

    $sql = "SELECT balance FROM customers WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($balance);
        $stmt->fetch();

        echo json_encode(["status" => "success", "balance" => $balance]);

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Query failed"]);
    }

    $conn->close();
}
?>

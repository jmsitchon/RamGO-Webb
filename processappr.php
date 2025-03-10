<?php
include '../dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    if (isset($_POST['approve'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "UPDATE employee SET status = 'approved', password = ? WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $password, $id);

        if ($stmt->execute()) {
            header("Location: approval.php?message=Approved");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif (isset($_POST['reject'])) {
        $sql = "DELETE FROM employee WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: approval.php?message=Rejected");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>

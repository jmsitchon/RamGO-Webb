<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = rand(46454, 99999); // Generate a random Employee ID
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthdate = $_POST['birthdate'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $hiredate = date("Y-m-d"); // Automatically set hire date to today
    $position = "Van Driver"; // Default position
    $status = "pending"; // Default status for admin approval

    // Insert into employee table
    $sql = "INSERT INTO employee (employee_id, first_name, last_name, birthdate, email, phone, hiredate, position, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssss", $employee_id, $first_name, $last_name, $birthdate, $email, $phone, $hiredate, $position, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Employee registered successfully! Pending admin approval.'); window.location.href='log-in.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        form { display: inline-block; text-align: left; padding: 20px; border: 1px solid #ccc; width: 300px; }
        input { display: block; width: 100%; padding: 10px; margin-bottom: 10px; }
        button { padding: 10px; background: green; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<h2>Employee Registration</h2>
<form method="POST" action="">
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="date" name="birthdate" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone Number" required>
    <button type="submit">Register</button>
</form>

</body>
</html>

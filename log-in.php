<?php
session_start();
include 'dbconnect.php';  // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email is numeric for employee login
    if (is_numeric($email)) { 
        // Employee login logic
        $sql = "SELECT * FROM employee WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $email); 
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['employee_id'] = $user['employee_id'];
            $_SESSION['role'] = $user['role'];

            // Direct redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: admin/dashh.php"); // Admin redirect
                exit();
            } else {
                header("Location: employee/employeedash.php"); // Employee redirect
                exit();
            }
        } else {
            echo "Invalid credentials for employee.";
        }
    } else { 
        // Customer login logic
        $sql = "SELECT id, username, password, email, balance FROM customers WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($customer_id, $username, $hashed_password, $email, $balance);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $customer_id;
                $_SESSION['username'] = $username;
                $_SESSION['balance'] = $balance; // Store balance
                $_SESSION['email'] = $email; // Store email for future use

                // Direct redirect to customer dashboard
                header("Location: customers/customerdash.php"); 
                exit();
            } else {
                echo "Invalid credentials for customer.";
            }
        } else {
            echo "Customer not found.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

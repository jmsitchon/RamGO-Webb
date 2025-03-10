<?php
$host = 'localhost';
$dbname = 'ramgo_app';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT password, balance FROM customers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $balance);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            
            echo json_encode(["status" => "success", "balance" => $balance]);
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        h2 { margin-bottom: 20px; }
        .container { display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; }
        .button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 18px;
            text-decoration: none;
            color: white;
            background: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .button:hover { background: #0056b3; }
    </style>
</head>
<body>

<h2>Admin Dashboard</h2>

<div class="container">
    <a href="approval.php" class="button">Approve Applicants</a>
    <a href="adminrides.php" class="button">Approve Rides</a>
    <a href="employee_details.php" class="button">View Employee Details</a>
</div>

</body>
</html>
                  
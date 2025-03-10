<?php
include '../dbconnect.php';

$sql = "SELECT * FROM employee WHERE status = 'pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approval</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        button { padding: 5px 10px; margin: 5px; cursor: pointer; }
        .approve { background: green; color: white; }
        .reject { background: red; color: white; }
    </style>
</head>
<body>

<h2>Pending Employee Applications</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Password</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= htmlspecialchars($row['employee_id']) ?></td>
        <td><?= htmlspecialchars($row['first_name'] . " " . $row['last_name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td>
            <form action="processappr.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['employee_id']) ?>">
                <input type="hidden" name="full_name" value="<?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']) ?>">
                <input type="hidden" name="phone" value="<?= htmlspecialchars($row['phone']) ?>">
                <input type="password" name="password" required placeholder="Set Password">
        </td>
        <td>
                <button type="submit" name="approve" class="approve">Approve</button>
                <button type="submit" name="reject" class="reject">Reject</button>
            </form>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>

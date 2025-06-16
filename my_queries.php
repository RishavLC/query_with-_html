<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM queries WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Queries</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
<a href="home.php">Home</a>

<h2>My Submitted Queries</h2>
<table>
    <tr>
        <th>Subject</th>
        <th>Message</th>
        <th>Status</th>
        <th>Admin Response</th>
        <th>Submitted On</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['response'])) ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
    <?php } ?>

</table>

</body>
</html>

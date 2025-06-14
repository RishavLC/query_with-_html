<?php
session_start();
include "config.php";

if ($_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query_id = $_POST['query_id'];
    $response = $_POST['response'];
    $status = $_POST['status'];

    $sql = "UPDATE queries SET response = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $response, $status, $query_id);

    if ($stmt->execute()) {
        echo "✅ Query updated successfully!";
        echo "<br><a href='admin.php'>Back to Admin Panel</a>";
    } else {
        echo "❌ Error updating query: " . $stmt->error;
    }

    $stmt->close();
}
?>

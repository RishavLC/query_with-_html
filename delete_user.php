<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Optional: Delete user's queries too
    $conn->query("DELETE FROM queries WHERE user_id = $user_id");

    // Now delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    header("Location: admin.php");
    exit;
} else {
    echo "Invalid request.";
}

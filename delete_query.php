<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied.";
    exit;
}

include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['query_id'])) {
    $query_id = $_POST['query_id'];

    // // First delete any responses tied to the query (optional, if you have a response table)
    // $conn->query("DELETE FROM responses WHERE query_id = $query_id");

    // Then delete the query
    $stmt = $conn->prepare("DELETE FROM queries WHERE id = ?");
    $stmt->bind_param("i", $query_id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.php");
    exit;
} else {
    echo "Invalid request.";
}

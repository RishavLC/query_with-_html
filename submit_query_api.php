<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['subject']) && isset($data['message'])) {
    $user_id = $_SESSION['user_id'];
    $subject = $data['subject'];
    $message = $data['message'];

    $stmt = $conn->prepare("INSERT INTO queries (user_id, subject, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $subject, $message);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
}

<?php
include "config.php";
session_start();

if ($_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);

    if ($stmt->execute()) {
        echo "User updated successfully. <a href='manage_users.php'>Back to list</a>";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    exit;
}

// Fetch current user data
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
?>

<h2>Edit User</h2>
<form method="post">
    Name: <input type="text" name="name" value="<?= $user['name'] ?>" required><br><br>
    Email: <input type="email" name="email" value="<?= $user['email'] ?>" required><br><br>
    Role:
    <select name="role">
        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
    </select><br><br>
    <button type="submit">Update</button>
</form>

<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // $role = 'user'; // default role
    $role = $_POST['role']; // Add this line instead of hardcoding 'user'


    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        echo "User registered. <a href='login.php'>Login now</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- HTML form -->
<h2>Register</h2>
<form method="post">
    <select name="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
    </select><br><br>
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Register</button>
</form>

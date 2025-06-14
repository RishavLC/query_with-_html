<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include "config.php";
?>

<h2>Admin Dashboard</h2>

<!-- View All Users -->
<h3>Manage Users</h3>
<table border="1" cellpadding="8">
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
    </tr>

    <?php
    $sql = "SELECT * FROM users WHERE role != 'admin'";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>{$row['role']}</td>
                <td>
                    <a href='edit_user.php?id={$row['id']}'>Edit</a>
                </td>
                <td>
                    <form method='POST' action='delete_user.php' onsubmit=\"return confirm('Are you sure you want to delete this user?');\">
                        <input type='hidden' name='user_id' value='{$row['id']}'>
                        <button type='submit'>Delete</button>
                    </form>
                </td>
              </tr>";
    }
    ?>
</table>

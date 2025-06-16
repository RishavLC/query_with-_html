<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
echo "Welcome, " . $_SESSION['name'] . " | <a href='logout.php'>Logout</a><br><br>";
?>
<?php
include "config.php";

// Check if admin
if ($_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Fetch all queries
$sql = "SELECT q.*, u.name FROM queries q JOIN users u ON q.user_id = u.id ORDER BY q.created_at DESC";
$result = $conn->query($sql);
?>
<a href="home.php">Home</a>
<h2>Admin Panel</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>User</th><th>Subject</th><th>Message</th><th>Status</th><th>Response</th><th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>    
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['subject'] ?></td>
            <td><?= $row['message'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['response'] ?></td>
            <td>
                <form method="post" action="respond.php">
                    <input type="hidden" name="query_id" value="<?= $row['id'] ?>">
                    <textarea name="response" placeholder="Enter response"></textarea><br>
                    <select name="status">
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option>
                    </select>
                    <button type="submit">Submit</button>
                </form>
                <form method="POST" action="delete_query.php" onsubmit="return confirm('Delete this query?');" style="display:inline-block">
                    <input type="hidden" name="query_id" value="<?= $row['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

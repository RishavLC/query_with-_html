<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - Query Management System</title>
</head>
<body>
    <h2>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</h2>

    <ul>
        <?php if ($_SESSION['role'] === 'user') : ?>
        <li><a href="submit_query_form.php">Submit a Query</a></li>
        <li><a href="my_queries.php">View My Queries</a></li>
<?php endif; ?>
        <?php if ($_SESSION['role'] === 'admin') : ?>
            <li><a href="admin.php">Admin Dashboard</a></li>
            <li><a href="register.php">Register</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
<?php endif; ?>

        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>

<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$users = query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список пользователей</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    
    <h1>Список пользователей</h1>
    
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?= htmlspecialchars($user['username']) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <?php include 'footer.php'; ?>
</div>
</body>
</html>
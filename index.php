<?php
session_start();
require_once 'config.php';
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$other_users = query("SELECT u.id, u.username, w.wish_text, w.created_at
                      FROM users u
                      JOIN wishes w ON u.id = w.user_id
                      WHERE u.id <> ?
                      ORDER BY w.created_at DESC",
                     [$user_id]);
$i = 0;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    <h1>Добро пожаловать!</h1>
</div>
</body>
<div class="container">
    <h1>Последние <?php echo COUNT_WISHES?> желаний других пользователей</h1>
    <?php if (count($other_users) > 0): ?>
        <ul>
            <?php foreach ($other_users as $user): ?>
                <li>
                <?php $i++; ?>
                    <strong><?= htmlspecialchars($user['username']) ?>:</strong> <?= htmlspecialchars($user['wish_text']) ?> —
                    (добавлено: <?= date('d.m.Y H:i', strtotime($user['created_at'])) ?>)
                <?php if ($i == COUNT_WISHES): ?>
                    <?php break; ?><?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</html>
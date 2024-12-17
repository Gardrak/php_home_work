<?php
session_start();
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
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Желания других пользователей</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    
    <h1>Желания других пользователей</h1>
    <form action="" method="get">
        <label for="date_from">От:</label>
        <input type="date" name="date_from" id="date_from">
        <label for="date_to">До:</label>
        <input type="date" name="date_to" id="date_to">
        <button type="submit">Поиск</button>
    </form>
    <?php if (count($other_users) > 0): ?>
        <ul>
            <?php foreach ($other_users as $user): ?>
                <li>
                    <strong><?= htmlspecialchars($user['username']) ?>:</strong> <?= htmlspecialchars($user['wish_text']) ?> —
                    (добавлено: <?= date('d.m.Y H:i', strtotime($user['created_at'])) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Другие пользователи пока ничего не добавили в свои списки желаний.</p>
    <?php endif; ?>
    
    
</div>
</body>
<?php include 'footer.php'; ?>
</html>
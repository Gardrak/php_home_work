<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$wishes = query("SELECT * FROM wishes WHERE user_id = ?", [$user_id]);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой список желаний</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    
    <h1>Мой список желаний</h1>
    
    <a href="create_wish.php" class="btn">Добавить желание</a>
    
    <?php if (count($wishes) > 0): ?>
        <ul>
            <?php foreach ($wishes as $wish): ?>
                <li>
                    <?= htmlspecialchars($wish['wish_text']) ?> —
                    <a href="edit_wish.php?id=<?= $wish['id'] ?>">Изменить</a> |
                    <a href="delete_wish.php?id=<?= $wish['id'] ?>" onclick="return confirm('Вы уверены, что хотите удалить это желание?');">Удалить</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>У вас нет желаний. Добавьте первое!</p>
    <?php endif; ?>
    
    
</div>
</body>
<?php include 'footer.php'; ?>
</html>
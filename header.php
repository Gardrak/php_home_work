<?php
session_start();
?>

<nav>
    <ul>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="index.php">Главная</a></li>
            <li><a href="wishlist.php">Мой список желаний</a></li>
            <li><a href="others_wishlist.php">Желания других пользователей</a></li>
            <li><a href="logout.php">Выйти</a></li>
        <?php else: ?>
            <p>Чтобы начать пользоваться системой, пожалуйста, войдите или зарегистрируйтесь.</p>
        <?php endif; ?>
    </ul>
</nav>

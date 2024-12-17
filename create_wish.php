<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wish_text = trim($_POST['wish_text']);
    if (empty($wish_text)) {
        $error = 'Пожалуйста, введите текст вашего желания.';
    } else {
        $user_id = $_SESSION['user_id'];
        query("INSERT INTO wishes (user_id, wish_text) VALUES (?, ?)", [$user_id, $wish_text]);
        header('Location: wishlist.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление желания</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    
    <h1>Добавление желания</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <textarea name="wish_text" rows="5"></textarea><br><br>
        <button type="submit">Добавить</button>
    </form>
    
    
</body>
</div>
<?php include 'footer.php'; ?>
</html>
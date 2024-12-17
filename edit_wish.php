<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wish_id = $_GET['id'];
    $wish_text = trim($_POST['wish_text']);
    if (empty($wish_text)) {
        $error = 'Пожалуйста, введите текст вашего желания.';
    } else {
        query("UPDATE wishes SET wish_text = ? WHERE id = ?", [$wish_text, $wish_id]);
        header('Location: wishlist.php');
        exit;
    }
} else {
    $wish_id = $_GET['id'];
    $wish = query("SELECT * FROM wishes WHERE id = ?", [$wish_id])[0];
    if (!$wish || $wish['user_id'] != $_SESSION['user_id']) {
        header('Location: wishlist.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование желания</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    
    <h1>Редактирование желания</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    
    <form action="<?= $_SERVER['PHP_SELF'] . '?id=' . $wish_id ?>" method="post">
        <textarea name="wish_text" rows="5"><?= htmlspecialchars($wish['wish_text']) ?></textarea><br><br>
        <button type="submit">Сохранить изменения</button>
    </form>
    
    
</div>
</body>
<?php include 'footer.php'; ?>
</html>
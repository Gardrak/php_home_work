<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Проверяем наличие пользователя в базе данных
    $user = query("SELECT * FROM users WHERE email = ?", [$email]);
    if (count($user) == 1 && password_verify($password, $user[0]['password'])) {
        // Авторизация успешна, устанавливаем сессию
        $_SESSION['user_id'] = $user[0]['id'];
        header('Location: wishlist.php');
        exit;
    } else {
        $error = 'Неверный адрес электронной почты или пароль.';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    
    <h1>Вход</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="email">Электронная почта:</label><br>
        <input type="email" name="email" id="email"><br><br>
        
        <label for="password">Пароль:</label><br>
        <input type="password" name="password" id="password"><br><br>
        
        <button type="submit">Войти</button>
    </form>
    
    
</div>
</body>
<?php include 'footer.php'; ?>
</html>
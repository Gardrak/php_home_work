<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверка полей формы
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username)) {
        $error = 'Пожалуйста, введите имя.';
    } elseif (empty($email)) {
        $error = 'Пожалуйста, введите адрес электронной почты.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Неверный формат адреса электронной почты.';
    } elseif (strlen($password) < 6) {
        $error = 'Пароль должен содержать минимум 6 символов.';
    } elseif ($password !== $confirm_password) {
        $error = 'Пароли не совпадают.';
    } else {
        // Проверяем, существует ли уже такой email
        $exists = get_value("SELECT COUNT(*) FROM users WHERE email = ?", [$email]);
        if ($exists > 0) {
            $error = 'Этот адрес электронной почты уже используется.';
        } else {
            // Хешируем пароль перед сохранением
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Вставляем данные пользователя в базу данных
            $user_id = insert_and_get_id('users', [
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password
            ]);

            if ($user_id) {
                // Успешная регистрация, переходим на страницу входа
                header('Location: login.php?registered=1');
                exit;
            } else {
                $error = 'Ошибка при регистрации. Попробуйте еще раз.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <?php include 'header.php'; ?>
    
    <h1>Регистрация</h1>
    
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="username">Имя:</label><br>
        <input type="text" name="username" id="username"><br><br>
        
        <label for="email">Электронная почта:</label><br>
        <input type="email" name="email" id="email"><br><br>
        
        <label for="password">Пароль:</label><br>
        <input type="password" name="password" id="password"><br><br>
        
        <label for="confirm_password">Подтвердите пароль:</label><br>
        <input type="password" name="confirm_password" id="confirm_password"><br><br>
        
        <button type="submit">Зарегистрироваться</button>
    </form>
    
    
</div>
</body>
<?php include 'footer.php'; ?>
</html>
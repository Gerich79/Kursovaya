<?php
session_start();

// Если пользователь уже авторизован, перенаправляем на Menu.php
if (isset($_SESSION['user'])) {
    header('Location: client/html/Menu.php');
    exit();
}

// Получаем сообщение об ошибке, если оно есть
$error = $_SESSION['error'] ?? '';
// Очищаем сообщение об ошибке после получения
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="rus">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="client/css/Auth.css">
    <title>Autorization</title>
</head>
<body>
    <div class='form-auth'>
        <?php if ($error): ?>
            <div class="error-message" style="color: red; margin-bottom: 15px; text-align: center;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form id="auth-form" method="POST" action="server/auth.php">
            <!-- input login -->
            <div class="input">
                <p class="input__span">Логин</p>
                <input class="input__box1" type="text" name="login" id="auth-login" required>
            </div>
            <!-- input password -->
            <div class="input">
                <p class="input__span">Пароль</p>
                <input class="input__box2" type="password" name="password" id="auth-password" required>
            </div>
            <div class="btns">
                <p class="span-auth">Нет профиля?<br><a class="link-auth" href="client/Registration.html">Создайте!</a></p>
                <button type="submit" class="btn-auth" id="auth-button">Вход</button>
            </div>
        </form>
    </div>
</body>
</html> 
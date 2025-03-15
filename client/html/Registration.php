<?php
session_start();

// Если пользователь уже авторизован, перенаправляем на Menu.php
if (isset($_SESSION['user'])) {
    header('Location: Menu.php');
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
    <link rel="stylesheet" href="../css/Reg.css">
    <title>Registration</title>
</head>
<body>
    <div class='form-reg'>
        <?php if ($error): ?>
            <div class="error-message" style="color: red; margin-bottom: 15px; text-align: center;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form id="reg-form" method="POST" action="../../server/register.php">
            <!-- input login -->
            <div class="input">
                <p class="input__span">Логин</p>
                <input class="input__box1" type="text" name="login" id="reg-login" required>
            </div>
            <!-- input password -->
            <div class="input">
                <p class="input__span">Пароль</p>
                <input class="input__box2" type="password" name="password" id="reg-password" required>
            </div>
            <div class="btns">
                <a class="btn-back" href="../../index.php">
                    <img class="img1" src="../img/arrow-return.png" alt="Назад">
                </a>
                <button type="submit" class="btn-create">Создать</button>
            </div>
        </form>
    </div>   
</body>
</html> 
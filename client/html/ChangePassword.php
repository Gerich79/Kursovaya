<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit();
}

// Получаем логин из URL
$login = $_GET['login'] ?? '';

// Получаем сообщение об ошибке или успехе, если оно есть
$message = $_SESSION['message'] ?? '';
$messageType = $_SESSION['message_type'] ?? '';
unset($_SESSION['message'], $_SESSION['message_type']);
?>
<!DOCTYPE html>
<html lang="rus">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/AddUser.css">
    <title>Изменение пароля</title>
</head>
<div class='form-add_user'>
    <?php if ($message): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="../../server/update_password.php" onsubmit="return validateForm()">
        <input type="hidden" name="login" value="<?php echo htmlspecialchars($login); ?>">
        
        <!-- Отображение выбранного пользователя -->
        <div class="input">
            <p class="input__span">Выбранный пользователь</p>
            <input class="input__box1" type="text" value="<?php echo htmlspecialchars($login); ?>" readonly>
        </div>
        
        <!-- input old password -->
        <div class="input">
            <p class="input__span">Текущий пароль</p>
            <input class="input__box2" type="password" name="old_password" maxlength="15" required>
        </div>
        
        <!-- input new password -->
        <div class="input">
            <p class="input__span">Новый пароль</p>
            <input class="input__box2" type="password" name="new_password" maxlength="15" required>
        </div>
        
        <div class="btns">
            <a href="AddUser.php" class="back-button">← Назад</a>
            <button type="submit" class="btn-edit"><img class="img3" src="../img/edit.png" alt="Сохранить"></button>
        </div>
    </form>
</div>

<script>
function validateForm() {
    const oldPassword = document.querySelector('input[name="old_password"]').value;
    const newPassword = document.querySelector('input[name="new_password"]').value;
    
    if (oldPassword.length > 15) {
        alert('Текущий пароль не может быть длиннее 15 символов');
        return false;
    }
    
    if (newPassword.length > 15) {
        alert('Новый пароль не может быть длиннее 15 символов');
        return false;
    }
    
    return true;
}
</script>
</html> 
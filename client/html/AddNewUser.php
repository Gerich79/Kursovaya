<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit();
}

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
    <title>Добавление пользователя</title>
</head>
<div class='form-add_user'>
    <?php if ($message): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="../../server/add_user.php" onsubmit="return validateForm()">
        <!-- input login -->
        <div class="input">
            <p class="input__span">Логин</p>
            <input class="input__box1" type="text" name="login" maxlength="20" required>
        </div>
        
        <!-- input password -->
        <div class="input">
            <p class="input__span">Пароль</p>
            <input class="input__box2" type="password" name="password" maxlength="15" required>
        </div>
        
        <!-- select role -->
        <div class="input">
            <p class="input__span">Роль</p>
            <select name="role" class="input__box1" required>
                <option value="">Выберите роль</option>
                <?php
                // Подключение к базе данных
                $conn = new mysqli("localhost", "root", "", "DB1");
                
                if ($conn->connect_error) {
                    die("Ошибка подключения: " . $conn->connect_error);
                }
                
                // Получаем список ролей
                $sql = "SELECT * FROM Roles";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id_role']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                }
                
                $conn->close();
                ?>
            </select>
        </div>
        
        <div class="btns">
            <button class="btn-back" onclick="window.location.href='AddUser.php'"><img class="img1" src="../img/arrow-return.png" alt="Назад"></button>
            <button type="submit" class="btn-create">Добавить пользователя</button>
        </div>
    </form>
</div>

<script>
function validateForm() {
    const login = document.querySelector('input[name="login"]').value;
    const password = document.querySelector('input[name="password"]').value;
    
    if (login.length > 20) {
        alert('Логин не может быть длиннее 20 символов');
        return false;
    }
    
    if (password.length > 15) {
        alert('Пароль не может быть длиннее 15 символов');
        return false;
    }
    
    return true;
}
</script>
</html> 
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
    <title>Управление пользователями</title>
</head>
<div class='form-add_user'>
    <?php if ($message): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- select login -->
    <div class="input">
        <p class="input__span">Логин</p>
        <select name="login" class="input__box1" id="userSelect" required>
            <option value="">Выберите пользователя</option>
            <?php
            // Подключение к базе данных
            $conn = new mysqli("localhost", "root", "", "DB1");
            
            if ($conn->connect_error) {
                die("Ошибка подключения: " . $conn->connect_error);
            }
            
            // Получаем список пользователей
            $sql = "SELECT login FROM Users";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['login']) . "'>" . htmlspecialchars($row['login']) . "</option>";
                }
            }
            
            $conn->close();
            ?>
        </select>
    </div>
    
    <div class="btns">
        <button class="btn-back" onclick="window.location.href='Menu.php'"><img class="img1" src="../img/arrow-return.png" alt="Назад"></button>
        <button type="button" class="btn-delete" onclick="deleteUser()"><img class="img2" src="../img/delete.png" alt="Удалить"></button>
        <button type="button" class="btn-plus" onclick="addUser()"><img class="img4" src="../img/plus.png" alt="Добавить"></button>
        <button type="button" class="btn-edit" onclick="changePassword()"><img class="img3" src="../img/edit.png" alt="Изменить пароль"></button>
    </div>
</div>

<script>
function deleteUser() {
    const login = document.getElementById('userSelect').value;
    if (!login) {
        alert('Пожалуйста, выберите пользователя');
        return;
    }
    
    if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
        window.location.href = `../../server/delete_user.php?login=${encodeURIComponent(login)}`;
    }
}

function addUser() {
    window.location.href = 'AddNewUser.php';
}

function changePassword() {
    const login = document.getElementById('userSelect').value;
    if (!login) {
        alert('Пожалуйста, выберите пользователя');
        return;
    }
    window.location.href = `ChangePassword.php?login=${encodeURIComponent(login)}`;
}
</script>
</html> 
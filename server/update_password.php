<?php
session_start();

// Проверяем, что запрос POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../client/html/AddUser.php');
    exit();
}

// Получаем данные из формы
$login = $_POST['login'] ?? '';
$old_password = $_POST['old_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';

// Проверяем наличие всех необходимых данных
if (empty($login) || empty($old_password) || empty($new_password)) {
    $_SESSION['message'] = 'Пожалуйста, заполните все поля';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/ChangePassword.php?login=' . urlencode($login));
    exit();
}

// Проверяем длину полей
if (strlen($old_password) > 15) {
    $_SESSION['message'] = 'Текущий пароль не может быть длиннее 15 символов';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/ChangePassword.php?login=' . urlencode($login));
    exit();
}

if (strlen($new_password) > 15) {
    $_SESSION['message'] = 'Новый пароль не может быть длиннее 15 символов';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/ChangePassword.php?login=' . urlencode($login));
    exit();
}

// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DB1";

// Установление соединения с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    $_SESSION['message'] = 'Ошибка подключения к базе данных';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/ChangePassword.php?login=' . urlencode($login));
    exit();
}

// Проверяем старый пароль
$checkSql = "SELECT * FROM Users WHERE login = ? AND password = ?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("ss", $login, $old_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['message'] = 'Неверный текущий пароль';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/ChangePassword.php?login=' . urlencode($login));
    exit();
}

// Обновляем пароль
$sql = "UPDATE Users SET password = ? WHERE login = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $new_password, $login);

if ($stmt->execute()) {
    $_SESSION['message'] = 'Пароль успешно изменен';
    $_SESSION['message_type'] = 'success';
    header('Location: ../client/html/AddUser.php');
    exit();
} else {
    $_SESSION['message'] = 'Ошибка при изменении пароля';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/ChangePassword.php?login=' . urlencode($login));
    exit();
}

$conn->close();
?> 
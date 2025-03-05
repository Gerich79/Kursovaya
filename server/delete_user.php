<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit();
}

// Проверяем, что передан логин
if (!isset($_GET['login'])) {
    $_SESSION['message'] = 'Не указан пользователь для удаления';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/AddUser.php');
    exit();
}

$login = $_GET['login'];

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
    header('Location: ../client/html/AddUser.php');
    exit();
}

// Удаляем пользователя
$sql = "DELETE FROM Users WHERE login = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $login);

if ($stmt->execute()) {
    $_SESSION['message'] = 'Пользователь успешно удален';
    $_SESSION['message_type'] = 'success';
} else {
    $_SESSION['message'] = 'Ошибка при удалении пользователя';
    $_SESSION['message_type'] = 'error';
}

$conn->close();

// Перенаправляем обратно на страницу управления пользователями
header('Location: ../client/html/AddUser.php');
exit();
?> 
<?php
// Настройки сессии
ini_set('session.cookie_lifetime', 0); // Сессия завершится при закрытии браузера
ini_set('session.gc_maxlifetime', 3600); // Максимальное время жизни сессии (1 час)
session_start();

// Включаем отображение ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Проверяем, что запрос POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
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
    error_log("Ошибка подключения к базе данных: " . $conn->connect_error);
    $_SESSION['error'] = 'Ошибка подключения к базе данных';
    header('Location: ../index.php');
    exit();
}

// Получаем данные из формы
$login = $_POST['login'];
$password = $_POST['password'];

// Отладочная информация
error_log("=== Начало процесса авторизации ===");
error_log("Полученные данные из формы:");
error_log("Login: " . $login);
error_log("Password: " . $password);

// Проверяем данные пользователя в таблице Users
$sql = "SELECT * FROM Users WHERE login='$login' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Пользователь найден
    $user = $result->fetch_assoc();
    
    // Удаляем пароль из данных пользователя
    unset($user['password']);
    
    // Сохраняем данные пользователя в сессию
    $_SESSION['user'] = $user;
    
    // Отладочная информация
    error_log("Пользователь найден и авторизован");
    error_log("Session data: " . print_r($_SESSION, true));
    
    // Проверяем существование файла Menu.html
    $menuPath = __DIR__ . '/../client/html/Menu.html';
    error_log("Checking Menu.html at path: " . $menuPath);
    
    if (!file_exists($menuPath)) {
        error_log("Menu.html not found at: " . $menuPath);
        $_SESSION['error'] = 'Ошибка: файл Menu.html не найден';
        header('Location: ../index.php');
        exit();
    }
    
    error_log("Menu.html found, redirecting...");
    
    // Перенаправляем на страницу меню
    $redirectUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/client/html/Menu.html';
    error_log("Redirecting to: " . $redirectUrl);
    header('Location: ' . $redirectUrl);
    exit();
} else {
    // Пользователь не найден или неверный пароль
    error_log("Пользователь не найден или неверный пароль");
    $_SESSION['error'] = 'Неверный логин или пароль';
    header('Location: ../index.php');
    exit();
}

// Закрываем соединение
$conn->close();
?> 
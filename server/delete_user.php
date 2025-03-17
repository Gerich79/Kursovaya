<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit();
}

// Проверяем, что передан логин
if (!isset($_GET['login']) || empty($_GET['login'])) {
    $_SESSION['message'] = 'Не указан пользователь для удаления';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/AddUser.php');
    exit();
}

$login = trim($_GET['login']);

// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DB1";

// Установление соединения с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Проверяем соединение
if ($conn->connect_error) {
    $_SESSION['message'] = 'Ошибка подключения к базе данных: ' . $conn->connect_error;
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/AddUser.php');
    exit();
}

try {
    // Начинаем транзакцию
    $conn->begin_transaction();

    // Проверяем существование пользователя
    $check_sql = "SELECT login FROM Users WHERE login = ?";
    $check_stmt = $conn->prepare($check_sql);
    if (!$check_stmt) {
        throw new Exception('Ошибка подготовки запроса: ' . $conn->error);
    }
    
    $check_stmt->bind_param("s", $login);
    if (!$check_stmt->execute()) {
        throw new Exception('Ошибка выполнения проверки: ' . $check_stmt->error);
    }
    
    $result = $check_stmt->get_result();
    if ($result->num_rows === 0) {
        throw new Exception('Пользователь не найден');
    }
    
    // Отключаем проверку внешних ключей
    $conn->query('SET FOREIGN_KEY_CHECKS=0');
    
    // Удаляем пользователя
    $sql = "DELETE FROM Users WHERE login = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception('Ошибка подготовки запроса удаления: ' . $conn->error);
    }
    
    $stmt->bind_param("s", $login);
    if (!$stmt->execute()) {
        throw new Exception('Ошибка выполнения удаления: ' . $stmt->error);
    }
    
    if ($stmt->affected_rows === 0) {
        throw new Exception('Не удалось удалить пользователя. Affected rows: ' . $stmt->affected_rows);
    }
    
    // Включаем обратно проверку внешних ключей
    $conn->query('SET FOREIGN_KEY_CHECKS=1');
    
    // Если всё успешно - фиксируем транзакцию
    $conn->commit();
    
    $_SESSION['message'] = 'Пользователь успешно удален';
    $_SESSION['message_type'] = 'success';
    
} catch (Exception $e) {
    // В случае ошибки - откатываем транзакцию
    $conn->rollback();
    $_SESSION['message'] = 'Ошибка: ' . $e->getMessage();
    $_SESSION['message_type'] = 'error';
} finally {
    if (isset($check_stmt)) $check_stmt->close();
    if (isset($stmt)) $stmt->close();
    $conn->close();
}

// Перенаправляем обратно на страницу управления пользователями
header('Location: ../client/html/AddUser.php');
exit();
?> 
<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit();
}

// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../client/html/form.html');
    exit();
}

// Получаем данные из формы
$name = $_POST['name'] ?? '';
$category = $_POST['category'] ?? '';
$technical_status = $_POST['technical_status'] ?? '';
$specifications = $_POST['specifications'] ?? '';
$date_added = $_POST['date_added'] ?? '';
$location = $_POST['location'] ?? '';
$cost = $_POST['cost'] ?? '';

// Проверяем обязательные поля
if (empty($name) || empty($category) || empty($technical_status) || empty($date_added) || empty($location) || empty($cost)) {
    $_SESSION['message'] = 'Пожалуйста, заполните все обязательные поля';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/form.html');
    exit();
}

try {
    // Подключение к базе данных
    $conn = new mysqli("localhost", "root", "", "DB1");
    
    if ($conn->connect_error) {
        throw new Exception("Ошибка подключения: " . $conn->connect_error);
    }
    
    // Устанавливаем кодировку
    $conn->set_charset("utf8");
    
    // Подготавливаем SQL запрос
    $sql = "INSERT INTO Components (name, description, date_added, technical_conditions, cost, id_categories, adreess) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Ошибка подготовки запроса: " . $conn->error);
    }
    
    $stmt->bind_param("ssssdis", $name, $specifications, $date_added, $technical_status, $cost, $category, $location);
    
    // Выполняем запрос
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Комплектующее успешно добавлено';
        $_SESSION['message_type'] = 'success';
        header('Location: ../client/html/Menu.php');
    } else {
        throw new Exception("Ошибка при добавлении комплектующего: " . $stmt->error);
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/form.html');
}

exit();

<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit();
}

// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../client/html/edit_component.html');
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

// Отладочная информация
error_log("=== Начало обработки запроса ===");
error_log("Полученные данные из формы:");
error_log("Название: " . $name);
error_log("Категория: " . $category);
error_log("Техническое состояние: " . $technical_status);
error_log("Спецификации: " . $specifications);
error_log("Дата: " . $date_added);
error_log("Местоположение: " . $location);
error_log("Стоимость: " . $cost);
error_log("Все POST данные:");
error_log(print_r($_POST, true));

// Проверяем обязательные поля
if (empty($name) || empty($category) || empty($technical_status) || empty($date_added) || empty($location) || empty($cost)) {
    $_SESSION['message'] = 'Пожалуйста, заполните все обязательные поля';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/edit_component.html');
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
    
    // Преобразуем категорию в целое число и стоимость в число с плавающей точкой
    $category = intval($category);
    $cost = floatval($cost);
    
    error_log("Преобразованные данные:");
    error_log("Категория (int): " . $category);
    error_log("Стоимость (float): " . $cost);
    
    // Проверяем существование комплектующего
    $check_sql = "SELECT * FROM Components WHERE name = ?";
    error_log("SQL запрос проверки: " . $check_sql);
    
    $check_stmt = $conn->prepare($check_sql);
    
    if (!$check_stmt) {
        throw new Exception("Ошибка подготовки проверочного запроса: " . $conn->error);
    }
    
    $check_stmt->bind_param("s", $name);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Комплектующее с указанным названием не найдено");
    }
    
    $old_data = $result->fetch_assoc();
    
    error_log("Старые данные из БД:");
    error_log(print_r($old_data, true));
    
    // Подготавливаем SQL запрос для обновления
    $sql = "UPDATE Components SET 
            description = ?, 
            date_added = ?, 
            technical_conditions = ?, 
            cost = ?, 
            id_categories = ?, 
            adreess = ?
            WHERE name = ?";
    
    error_log("SQL запрос обновления: " . $sql);
    
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Ошибка подготовки запроса обновления: " . $conn->error);
    }
    
    // Привязываем параметры в том же порядке, что и в SQL запросе
    $stmt->bind_param("sssdis", 
        $specifications,  // description
        $date_added,     // date_added
        $technical_status, // technical_conditions
        $cost,          // cost
        $category,      // id_categories
        $location,      // adreess
        $name          // WHERE name = ?
    );
    
    error_log("Параметры для обновления:");
    error_log("specifications: " . $specifications);
    error_log("date_added: " . $date_added);
    error_log("technical_status: " . $technical_status);
    error_log("cost: " . $cost);
    error_log("category: " . $category);
    error_log("location: " . $location);
    error_log("name: " . $name);
    
    // Выполняем запрос
    if ($stmt->execute()) {
        error_log("Запрос выполнен успешно");
        
        // Проверяем, действительно ли изменились данные
        $verify_sql = "SELECT * FROM Components WHERE name = ?";
        $verify_stmt = $conn->prepare($verify_sql);
        $verify_stmt->bind_param("s", $name);
        $verify_stmt->execute();
        $verify_result = $verify_stmt->get_result();
        $new_data = $verify_result->fetch_assoc();
        
        error_log("Новые данные из БД:");
        error_log(print_r($new_data, true));
        
        // Сравниваем старые и новые данные
        $changes = array();
        if ($old_data['description'] !== $new_data['description']) $changes[] = "Описание";
        if ($old_data['date_added'] !== $new_data['date_added']) $changes[] = "Дата";
        if ($old_data['technical_conditions'] !== $new_data['technical_conditions']) $changes[] = "Техническое состояние";
        if ($old_data['cost'] != $new_data['cost']) $changes[] = "Стоимость";
        if ($old_data['id_categories'] != $new_data['id_categories']) $changes[] = "Категория";
        if ($old_data['adreess'] !== $new_data['adreess']) $changes[] = "Местоположение";
        
        error_log("Измененные поля: " . implode(', ', $changes));
        
        if (empty($changes)) {
            $_SESSION['message'] = 'Данные не были изменены';
            $_SESSION['message_type'] = 'warning';
        } else {
            $_SESSION['message'] = 'Комплектующее успешно обновлено. Изменены поля: ' . implode(', ', $changes);
            $_SESSION['message_type'] = 'success';
        }
        
        header('Location: ../client/html/Menu.html');
    } else {
        throw new Exception("Ошибка при обновлении комплектующего: " . $stmt->error);
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    error_log("Ошибка: " . $e->getMessage());
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/edit_component.html');
}

error_log("=== Конец обработки запроса ===");
exit(); 
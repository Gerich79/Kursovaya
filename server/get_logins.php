<?php
header('Content-Type: application/json');

// Подключение к базе данных
$host = 'localhost';
$dbname = 'DB1';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Получаем логины из базы данных
    $stmt = $pdo->query("SELECT login FROM Users");
    $logins = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Отправляем логины в формате JSON
    echo json_encode($logins);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка базы данных: ' . $e->getMessage()]);
}
?> 
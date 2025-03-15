<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    // Проверка на пустые поля
    if (empty($login) || empty($password)) {
        $_SESSION['error'] = 'Все поля должны быть заполнены';
        header('Location: ../client/html/Registration.php');
        exit();
    }

    // Проверка длины пароля
    if (strlen($password) < 8) {
        $_SESSION['error'] = 'Пароль должен содержать минимум 8 символов';
        header('Location: ../client/html/Registration.php');
        exit();
    }

    // Проверка существования пользователя
    $stmt = $conn->prepare("SELECT id_user FROM Users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Пользователь с таким логином уже существует';
        header('Location: ../client/html/Registration.php');
        exit();
    }

    // Регистрация нового пользователя
    $stmt = $conn->prepare("INSERT INTO Users (login, password, id_role) VALUES (?, ?, 1)");
    $stmt->bind_param("ss", $login, $password);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Регистрация успешна! Войдите в систему.';
        header('Location: ../index.php');
    } else {
        $_SESSION['error'] = 'Ошибка при регистрации: ' . $conn->error;
        header('Location: ../client/html/Registration.php');
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: ../client/html/Registration.php');
}
?> 
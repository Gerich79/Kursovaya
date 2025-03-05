<?php
session_start();

// Проверяем, что запрос POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../client/html/AddNewUser.php');
    exit();
}

// Получаем данные из формы
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

// Проверяем наличие всех необходимых данных
if (empty($login) || empty($password) || empty($role)) {
    $_SESSION['message'] = 'Пожалуйста, заполните все поля';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/AddNewUser.php');
    exit();
}

// Проверяем длину полей
if (strlen($login) > 20) {
    $_SESSION['message'] = 'Логин не может быть длиннее 20 символов';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/AddNewUser.php');
    exit();
}

if (strlen($password) > 15) {
    $_SESSION['message'] = 'Пароль не может быть длиннее 15 символов';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/AddNewUser.php');
    exit();
}

// Параметры подключения к базе данных
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "DB1";

// Установление соединения с базой данных
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    $_SESSION['message'] = 'Ошибка подключения к базе данных';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/AddNewUser.php');
    exit();
}

// Проверяем, не существует ли уже такой логин
$checkSql = "SELECT * FROM Users WHERE login = ?";
$stmt = $conn->prepare($checkSql);
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['message'] = 'Пользователь с таким логином уже существует';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/AddNewUser.php');
    exit();
}

// Добавляем нового пользователя
$sql = "INSERT INTO Users (login, password, id_role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $login, $password, $role);

if ($stmt->execute()) {
    $_SESSION['message'] = 'Пользователь успешно добавлен';
    $_SESSION['message_type'] = 'success';
    header('Location: ../client/html/AddUser.php');
    exit();
} else {
    $_SESSION['message'] = 'Ошибка при добавлении пользователя';
    $_SESSION['message_type'] = 'error';
    header('Location: ../client/html/AddNewUser.php');
    exit();
}

$conn->close();
?> 
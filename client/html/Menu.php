<?php
// Настройки сессии
ini_set('session.cookie_lifetime', 0); // Сессия завершится при закрытии браузера
ini_set('session.gc_maxlifetime', 3600); // Максимальное время жизни сессии (1 час)
session_start();

// Проверка авторизации
if (!isset($_SESSION['user'])) {
    header('Location: ../../index.php');
    exit();
}

// Получаем данные пользователя
$user = $_SESSION['user'];

// Получаем роль пользователя из базы данных
require_once '../../server/db.php';
$sql = "SELECT r.name as role_name 
        FROM Users u 
        JOIN Roles r ON u.id_role = r.id_role 
        WHERE u.id_user = " . $user['id_user'];
$result = $conn->query($sql);
$role = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="rus">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Menu.css">
    <title>Menu</title>
</head>
<body>
    <div class="sidenav" id="mySidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="Messages.php"><img src="img/warning.png" alt="warning" class="menu-icon"> Сообщения</a>
        
        <?php if ($role['role_name'] === 'Администратор'): ?>
            <a href="AddUser.php"><img src="img/system.png" alt="system" class="menu-icon"> Управление профилями</a>
            <a href="form.html"><img src="img/system.png" alt="system" class="menu-icon"> Управление комплектующими</a>
        <?php endif; ?>
        <a href="declaration.php"><img src="img/profile.png" alt="profile" class="menu-icon">Написать о поломке</a>
        <a href="rating.php"><img src="img/profile.png" alt="profile" class="menu-icon">Выставить оценку комплектующему</a>
        <a href="DeletedPage.php"><img src="img/profile.png" alt="profile" class="menu-icon">Списанные комплектующие</a>
        <a href="RepairedPage.php"><img src="img/profile.png" alt="profile" class="menu-icon">Отремонтированные комплектующие</a>
        <a href="Reliability.php"><img src="img/profile.png" alt="profile" class="menu-icon">Топ комплектующих</a>
        <a href="../../server/logout.php" style="color: #ff4444;"><img src="img/logout.png" alt="logout" class="menu-icon"> Выйти</a>
    </div>

    <span class="menu-button" onclick="openNav()">&#9776;</span>

    <div class="form-menu">
        <div class="menu-up">
            <div class="tetx_container">
                <p class="menu_text" id="login">Логин: <?php echo htmlspecialchars($user['login']); ?></p>
                <p class="menu_text" id="role">Роль: <?php echo htmlspecialchars($role['role_name']); ?></p>
            </div>
        </div>
        <div class="category-menu">
            <a href="categories/CPU.php"><button class="category" title="Процессоры"><img class="img1" src="../img/cpu.png"></button></a>
            <a href="categories/VideoCard.php"><button class="category" title="Видеокарты"><img class="img2" src="../img/videocard.png"></button></a>
            <a href="categories/Motherboard.php"><button class="category" title="Материнские платы"><img class="img1" src="../img/mother plate.png"></button></a>
            <a href="categories/PowerSupply.php"><button class="category" title="Блоки питания"><img class="img1" src="../img/power suply.png"></button></a>
            <a href="categories/RAM.php"><button class="category" title="Оперативная память"><img class="img5" src="../img/ram.png"></button></a>
            <a href="categories/HDD.php"><button class="category" title="Жёсткий диск"><img class="img6" src="../img/hard drive.png"></button></a>
            <a href="categories/Monitor.php"><button class="category" title="Мониторы"><img class="img7" src="../img/monitor.png"></button></a>
            <a href="categories/Peripherals.php"><button class="category" title="Мышки и клавиатуры"><img class="img8" src="../img/keyboard and mouse.png"></button></a>
        </div>
    </div>
    <script src="../js/Menu.js"></script>
</body>
</html> 
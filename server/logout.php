<?php
session_start();

// Очищаем все данные сессии
session_unset();

// Уничтожаем сессию
session_destroy();

// Перенаправляем на страницу авторизации
header('Location: ../index.php');
exit();
?> 
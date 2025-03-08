<?php
$connect = mysqli_connect('localhost', 'root', '', 'DB1');

if (!$connect) {
    die('Error connect to DataBase');
}

// Устанавливаем кодировку
mysqli_set_charset($connect, "utf8");
?> 
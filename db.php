<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "company_support";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $database);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>

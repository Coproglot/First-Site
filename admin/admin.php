<?php
session_start();
include '../db.php';

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Административная панель</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Подключение стилей -->
</head>
<body>
    <header>
        <h1>Веб-сайт для предприятия Протек</h1>
        <a href="logout.php" class="logout-button">Выйти</a>
    </header>

    <main>
        <h2>Административная панель</h2>
		<div class="admin-main-button-container">
   		 <a href="manage_cartridges.php" class="admin-main-button">Форма для картриджа и количество оставшихся картриджей</a>
    		 <a href="replacement_history.php" class="admin-main-button">История замены</a>
    		 <a href="user_requests.php" class="admin-main-button">Заявки пользователей</a>
    		 <a href="cartridge_requests.php" class="admin-main-button">Запросы на замену картриджа</a>
		</div>

    </main>

    <?php include '../templates/footer.php'; ?>
</body>
</html>

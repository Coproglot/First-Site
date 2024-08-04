<?php
session_start();
include '../db.php'; // Подключение к базе данных

// Проверка, авторизован ли пользователь как администратор
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("У вас нет прав для доступа к этой странице.");
}

// Обработка данных формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "Имя пользователя и пароль не могут быть пустыми.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "Пользователь $username добавлен успешно.";
        } else {
            echo "Ошибка: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить нового администратора</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <h2>Добавить нового администратора</h2>

    <form action="create_admin.php" method="POST">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Добавить администратора">
    </form>

    <?php include '../templates/footer.php'; ?>
</body>
</html>

<?php
session_start();
include '../db.php';

// Проверка, был ли выполнен вход
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: admin.php');
    exit();
}

// Генерация токена CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Обработка данных формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проверка CSRF токена
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Неверный CSRF токен.');
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Имя пользователя и пароль обязательны.";
    } else {
        // Проверка учетных данных
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Установка сеанса
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role']; // Добавляем роль в сессию
            header('Location: admin.php');
            exit();
        } else {
            $error = "Неверное имя пользователя или пароль.";
        }

        $stmt->close();
    }

    $conn->close();
}
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

<div class="container">
    <h1>Вход в административную панель</h1>
    <form action="login.php" method="POST" class="login-form">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Войти" class="submit-button">
    </form>

    <?php
    if (isset($error)) {
        echo "<p class='error-message'>$error</p>";
    }
    ?>
</div>

<?php include '../templates/footer.php'; ?>

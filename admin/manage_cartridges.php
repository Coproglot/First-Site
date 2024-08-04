<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запросы на замену картриджа</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css"> <!-- Ссылка на CSS -->
</head>
<body>

<?php
session_start();
include '../db.php';

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_id = $_POST['department'];
    $printer_id = $_POST['printer'];
    $cartridge_id = $_POST['cartridge'];
    $quantity = $_POST['quantity'];

    // Обновление количества картриджей в базе данных
    $sql = "UPDATE cartridges SET quantity = quantity - $quantity WHERE id = '$cartridge_id'";
    if ($conn->query($sql) === TRUE) {
        // Добавление записи в историю замен
        $sql_history = "INSERT INTO history (department_id, printer_id, cartridge_id, quantity, replaced_by)
                        VALUES ('$department_id', '$printer_id', '$cartridge_id', '$quantity', 'Админ')";
        $conn->query($sql_history);

        echo "Количество картриджей обновлено и запись добавлена в историю.";
    } else {
        echo "Ошибка: " . $conn->error;
    }
}

// Получение данных для форм
$sql_departments = "SELECT id, name FROM departments";
$departments = $conn->query($sql_departments);

$sql_printers = "SELECT id, name FROM printers";
$printers = $conn->query($sql_printers);

$sql_cartridges = "SELECT id, name, quantity FROM cartridges";
$cartridges = $conn->query($sql_cartridges);

$conn->close();
?>

<?php include '../templates/header.php'; ?>

<h1>Управление картриджами</h1>

<form action="manage_cartridges.php" method="POST">
    <label for="department">Отдел:</label>
    <select name="department" required>
        <?php while($row = $departments->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select>

    <label for="printer">Принтер:</label>
    <select name="printer" required>
        <?php while($row = $printers->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select>

    <label for="cartridge">Картридж:</label>
    <select name="cartridge" required>
        <?php while($row = $cartridges->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?> (Доступно: <?= $row['quantity'] ?>)</option>
        <?php endwhile; ?>
    </select>

    <label for="quantity">Количество:</label>
    <input type="number" name="quantity" min="1" required>

    <input type="submit" value="Обновить количество">
</form>

<!-- Таблица со всеми картриджами и их количеством -->
<h2>Список всех картриджей и их количество</h2>
<table>
    <thead>
        <tr>
            <th>Картридж</th>
            <th>Доступное количество</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Снова открываем соединение с базой данных, чтобы получить данные для таблицы
        include '../db.php';
        $sql_all_cartridges = "SELECT name, quantity FROM cartridges";
        $all_cartridges = $conn->query($sql_all_cartridges);

        if ($all_cartridges->num_rows > 0): ?>
            <?php while ($row = $all_cartridges->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Нет данных о картриджах</td>
            </tr>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </tbody>
</table>

<?php include '../templates/footer.php'; ?>

</body>
</html>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запросы на замену картриджа</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css"> <!-- Ссылка на CSS -->
</head>
<body>
<?php include '../templates/header.php'; ?>
<?php
include '../db.php';  // Проверьте правильность пути к db.php

// SQL-запрос для получения всех запросов на замену картриджей с добавлением даты
$sql = "SELECT r.id, d.name AS department, p.name AS printer, c.name AS cartridge, r.surname, r.quantity, r.created_at 
        FROM cartridge_requests r
        JOIN departments d ON r.department_id = d.id
        JOIN printers p ON r.printer_id = p.id
        JOIN cartridges c ON r.cartridge_id = c.id";

// Выполнение запроса
$requests = $conn->query($sql);

// Закрытие соединения с базой данных
$conn->close();
?>

<h1>Запросы на замену картриджа</h1>

<table>
    <thead>
        <tr>
            <th>№</th> <!-- Порядковый номер -->
            <th>Отдел</th>
            <th>Принтер</th>
            <th>Картридж</th>
            <th>Фамилия</th>
            <th>Количество</th>
            <th>Дата запроса</th> <!-- Дата запроса -->
        </tr>
    </thead>
    <tbody>
        <?php if ($requests->num_rows > 0): ?>
            <?php $counter = 1; ?> <!-- Счетчик для порядкового номера -->
            <?php while ($row = $requests->fetch_assoc()): ?>
                <tr>
                    <td><?= $counter ?></td> <!-- Вывод порядкового номера -->
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['printer']) ?></td>
                    <td><?= htmlspecialchars($row['cartridge']) ?></td>
                    <td><?= htmlspecialchars($row['surname']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td> <!-- Вывод даты запроса -->
                </tr>
                <?php $counter++; ?> <!-- Увеличение счетчика -->
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Нет запросов</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
// Проверка, существует ли файл footer.php
if (file_exists('../templates/footer.php')) {
    include '../templates/footer.php';
} else {
    echo '<p>Файл footer.php не найден. Проверьте путь.</p>';
}
?>

</body>
</html>

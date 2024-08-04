<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>История замен картриджей</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css"> <!-- Ссылка на CSS -->
</head>
<body>

<?php
include '../db.php';  // Убедитесь, что путь к db.php правильный

// Запрос для получения данных из таблицы history
$sql = "SELECT h.id, d.name AS department, p.name AS printer, c.name AS cartridge, h.quantity, h.replaced_by, h.replacement_date 
        FROM history h 
        JOIN departments d ON h.department_id = d.id 
        JOIN printers p ON h.printer_id = p.id 
        JOIN cartridges c ON h.cartridge_id = c.id 
        ORDER BY h.replacement_date DESC";

$result = $conn->query($sql);

$conn->close();
?>

<?php include '../templates/header.php'; ?>

<h1>История замен картриджей</h1>

<table>
    <thead>
        <tr>
            <th>№</th> <!-- Изменено на порядковый номер -->
            <th>Отдел</th>
            <th>Принтер</th>
            <th>Картридж</th>
            <th>Количество</th>
            <th>Кто заменил</th>
            <th>Дата замены</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php $counter = 1; ?> <!-- Счётчик для порядкового номера -->
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $counter++ ?></td> <!-- Вывод порядкового номера и увеличение счётчика -->
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['printer']) ?></td>
                    <td><?= htmlspecialchars($row['cartridge']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars($row['replaced_by']) ?></td>
                    <td><?= htmlspecialchars($row['replacement_date']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Нет записей в истории</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../templates/footer.php'; ?>
</body>
</html>

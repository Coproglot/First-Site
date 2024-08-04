<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявки пользователей</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css"> <!-- Ссылка на CSS -->
</head>
<body>

<?php
include '../db.php';  // Проверьте правильность пути к db.php

// SQL-запрос для получения всех заявок пользователей
$sql = "SELECT t.id, d.name AS department, t.surname, t.issue_description, t.created_at 
        FROM issue_tickets t 
        JOIN departments d ON t.department_id = d.id";

// Выполнение запроса
$requests = $conn->query($sql);

// Закрытие соединения с базой данных
$conn->close();
?>

<?php include '../templates/header.php'; ?>

<h1>Заявки пользователей</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Отдел</th>
            <th>Фамилия</th>
            <th>Описание проблемы</th>
            <th>Дата заявки</th> <!-- Новый столбец -->
        </tr>
    </thead>
    <tbody>
        <?php if ($requests->num_rows > 0): ?>
            <?php while ($row = $requests->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['surname']) ?></td>
                    <td><?= htmlspecialchars($row['issue_description']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td> <!-- Дата заявки -->
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Нет заявок</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include '../templates/footer.php'; ?>
</body>
</html>

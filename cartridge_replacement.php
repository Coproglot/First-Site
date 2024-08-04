<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_id = $_POST['department'];
    $printer_id = $_POST['printer'];
    $cartridge_id = $_POST['cartridge'];
    $surname = $_POST['surname'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO cartridge_requests (department_id, printer_id, cartridge_id, surname, quantity) 
            VALUES ('$department_id', '$printer_id', '$cartridge_id', '$surname', '$quantity')";

    if ($conn->query($sql) === TRUE) {
        header('Location: confirmation.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT id, name FROM departments";
$departments = $conn->query($sql);

$sql = "SELECT id, name FROM printers";
$printers = $conn->query($sql);

$sql = "SELECT id, name FROM cartridges";
$cartridges = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Замена картриджа</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<?php include 'templates/header.php'; ?>

<form action="cartridge_replacement.php" method="POST">
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
            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
        <?php endwhile; ?>
    </select>

    <label for="surname">Фамилия:</label>
    <input type="text" name="surname" required>

    <label for="quantity">Количество:</label>
    <input type="number" name="quantity" min="1" required>

    <input type="submit" value="Отправить запрос">
</form>

<?php include 'templates/footer.php'; ?>

</html>

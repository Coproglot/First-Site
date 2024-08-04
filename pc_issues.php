<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department_id = $_POST['department'];
    $surname = $_POST['surname'];
    $issue_description = $_POST['issue_description'];

    $sql = "INSERT INTO issue_tickets (department_id, surname, issues_description) 
            VALUES ('$department_id', '$surname', '$issue_description')";

    if ($conn->query($sql) === TRUE) {
        header('Location: confirmation.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT id, issue_name, solution FROM issues";
$issues = $conn->query($sql);

$sql = "SELECT id, name FROM departments";
$departments = $conn->query($sql);

$conn->close();
?>

<?php include 'templates/header.php'; ?>

<!-- Блок для выбора проблемы и отображения решения -->
<section id="issue-section">
    <form id="issue-form">
        <label for="issue">Выберите проблему:</label>
        <select id="issue" name="issue">
            <option value="">Выберите проблему</option>
            <?php while($row = $issues->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" data-solution="<?= htmlspecialchars($row['solution']) ?>"><?= $row['issue_name'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="button" id="show-solution">Показать инструкцию</button>
    </form>

    <div id="solution" style="display:none;">
        <h3>Решение:</h3>
        <p id="solution-text"></p>
    </div>
</section>

<hr>

<!-- Блок для заполнения формы, если проблема не была найдена -->
<section id="form-section">
    <h3>Не нашли проблему? Опишите ее:</h3>
    <form action="pc_issues.php" method="POST">
        <label for="department">Отдел:</label>
        <select name="department" required>
            <?php while($row = $departments->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="surname">Фамилия:</label>
        <input type="text" name="surname" required>

        <label for="issue_description">Описание проблемы:</label>
        <textarea name="issue_description" required></textarea>

        <input type="submit" value="Отправить заявку">
    </form>
</section>

<script>
document.getElementById('show-solution').addEventListener('click', function() {
    var issueSelect = document.getElementById('issue');
    var solutionText = issueSelect.options[issueSelect.selectedIndex].getAttribute('data-solution');

    if (solutionText) {
        document.getElementById('solution-text').innerText = solutionText;
        document.getElementById('solution').style.display = 'block';
    } else {
        alert('Пожалуйста, выберите проблему.');
    }
});
</script>

<?php include 'templates/footer.php'; ?>

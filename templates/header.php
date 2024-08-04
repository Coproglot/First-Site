<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Веб-сайт для предприятия</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['cartridge_replacement.php', 'pc_issues.php', 'third_function.php']) ? 'page-with-back-button' : ''; ?>">
    <header>
        <div class="container">
            <div class="header-content">
                <h1>Веб-сайт для предприятия Протек</h1>
                <a href="logout.php" class="logout-button">Выйти</a>
            </div>
            <nav class="header-nav">
                <ul>
                    <!-- Другие элементы навигации -->
                </ul>
                
                <?php
                // Определяем массив URL-ов страниц, на которых кнопка "На главную" должна отображаться для основной части сайта
                $pages_with_back_button = ['cartridge_replacement.php', 'pc_issues.php', 'third_function.php'];
                
                // Определяем массив URL-ов страниц админ панели, на которых кнопка "На главную" должна отображаться
                $admin_pages_with_back_button = [
                    'cartridge_form.php', 
                    'history.php', 
                    'user_requests.php', 
                    'cartridge_requests.php',
                    'replacement_history.php',
                    'manage_cartridges.php'
                ];

                // Получаем текущий URL
                $current_page = basename($_SERVER['PHP_SELF']);
                ?>

                <!-- Кнопка "На главную" для основной части сайта -->
                <?php if (in_array($current_page, $pages_with_back_button)): ?>
                    <a href="index.php" class="button back-to-home">На главную</a>
                <?php endif; ?>

                <!-- Кнопка "На главную" для админ панели -->
                <?php if (in_array($current_page, $admin_pages_with_back_button)): ?>
                    <a href="admin.php" class="button back-to-admin-home">На главную админ панель</a>
                <?php endif; ?>

            </nav>
        </div>
    </header>
    <!-- Остальная часть страницы -->
</body>
</html>
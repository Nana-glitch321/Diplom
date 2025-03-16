<?php
    session_start();
    $title = "Темы - PodcasterPro"; 
    $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';

    // Подключаем базу данных
    include '../php/database/db.php';

    // Получаем данные о жанрах
    $query = "SELECT * FROM genres"; // Запрос для получения всех жанров
    $result = $conn->query($query);

    // Проверка на ошибки выполнения запроса
    if (!$result) {
        die("Ошибка запроса: " . $conn->error);
    }

    // Извлекаем все жанры
    $genres = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
    <?php include '../php/page_templates/head.php'; ?>
    <body>
        <?php include '../php/page_templates/header.php'; ?>
        <?php include '../php/page_templates/auth.php'; ?>

        <main>
            <div class="card-container">
                <?php foreach ($genres as $genre): ?>
                    <div class="card">
                        <img src="../picture/<?php echo htmlspecialchars($genre['image_url']); ?>" alt="<?php echo htmlspecialchars($genre['name']); ?>">
                        <div class="card-content">
                            <button class="favorite-btn" data-topic="<?php echo htmlspecialchars($genre['name']); ?>" data-genre-id="<?php echo $genre['id']; ?>" data-user-id="<?php echo $_SESSION['user_id']; ?>">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                            <h3><?php echo htmlspecialchars($genre['name']); ?></h3>
                            <p><?php echo htmlspecialchars($genre['description']); ?></p>
                            <a href="" class="btn">К подкастам</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>

        <script src="../js/script_login_register.js"></script>
        <script src="../js/check_account.js"></script>
        <script src="../js/add_favorite_genre.js"></script>
        <style> 
            <?php include '../css/style_theme.css' ?>
            <?php include '../css/page_template_styles/style_header.css' ?>
            <?php include '../css/page_template_styles/style_auth.css' ?>
        </style>

        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>
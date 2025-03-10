<?php
session_start();
$title = "Популярное - PodcasterPro"; 
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
require_once '../php/database/db.php';

// Получаем последние 5 подкастов
$sql = "SELECT * FROM Podcast ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($sql);

$podcasts = [];
$podcastIds = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $podcasts[] = $row;
        $podcastIds[] = $row['id'];
    }
}

// Проверяем, какие подкасты в избранном, если пользователь залогинен
$isFavorite = [];

if (!empty($user_id) && !empty($podcastIds)) {
    $placeholders = implode(',', array_fill(0, count($podcastIds), '?'));
    $query = "SELECT podcast_id FROM favorites WHERE user_id = ? AND podcast_id IN ($placeholders)";

    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Ошибка в подготовке запроса: " . $conn->error);
    }

    // Привязываем параметры
    $types = str_repeat('i', count($podcastIds) + 1);
    $params = array_merge([$user_id], $podcastIds);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $isFavorite[$row['podcast_id']] = true;
        }
    } else {
        die("Ошибка выполнения запроса: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
    <?php include '../php/page_templates/head.php'; ?>
    <body>
        <main id="page-content">
            <?php include '../index/index_pop.html'; ?>

            <div class="podcast-list" style="margin: 250px">
                <?php foreach ($podcasts as $podcast): ?>
                    <?php include '../php/page_templates/podcast.php'; ?>
                <?php endforeach; ?>
            </div>
        </main>
        <?php include '../php/page_templates/header.php'; ?>

        <script>
            const userFavorites = <?php echo json_encode($isFavorite); ?>;
        </script>
        <style> 
            <?php include '../css/style_pop.css' ?>
            <?php include '../css/page_template_styles/style_header.css' ?>
            <?php include '../css/page_template_styles/style_auth.css' ?>
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <script src="../js/add_favorites.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
</html>

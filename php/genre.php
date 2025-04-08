<?php
session_start();
$title = "Подкасты по темам - PodcasterPro"; 
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
require_once '../php/database/db.php';

// Получаем жанр из URL
$genre_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($genre_id === 0) {
    die("Ошибка: Неверная тема.");
}

// Запрос информации о жанре
$query = "SELECT * FROM genres WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $genre_id);
$stmt->execute();
$result = $stmt->get_result();
$genre = $result->fetch_assoc();

if (!$genre) {
    die("Ошибка: Тема не найдена.");
}

// Получаем подкасты этого жанра
$query = "SELECT podcast.*, genres.name AS genre_name
          FROM podcast
          JOIN podcast_genre ON podcast.id = podcast_genre.podcast_id
          JOIN genres ON podcast_genre.genre_id = genres.id
          WHERE genres.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $genre_id);
$stmt->execute();
$podcasts_result = $stmt->get_result();

$podcasts = [];
$podcastIds = [];

if ($podcasts_result && $podcasts_result->num_rows > 0) {
    while ($row = $podcasts_result->fetch_assoc()) {
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php include '../php/page_templates/head.php'; ?>
    <style> 
        <?php include '../css/style_pop.css'; ?>
        <?php include '../css/page_template_styles/style_header.css'; ?>
        <?php include '../css/page_template_styles/style_auth.css'; ?>
    </style>
</head>
<body>
    <?php include '../php/page_templates/header.php'; ?>
    <main>
    <h1 class="genre-title">Подкасты по теме: <?php echo htmlspecialchars($genre['name']); ?></h1>
        <div class="podcast-list" style="margin: 250px">
            <?php if (empty($podcasts)): ?>
                <p>Нет подкастов по этой теме.</p>
            <?php else: ?>
                <?php foreach ($podcasts as $podcast): ?>
                    <?php include '../php/page_templates/podcast.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../php/page_templates/auth.php'; ?>

    <script>
        const userFavorites = <?php echo json_encode($isFavorite); ?>;
    </script>

    <script src="../js/script_custom_audio_player.js"></script>
    <script src="../js/add_favorites.js"></script>
    <script src="../js/script_login_register.js"></script>
    <script src="../js/check_account.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

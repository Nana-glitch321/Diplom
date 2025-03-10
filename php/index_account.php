<?php
session_start();    
$title = "Страница пользователя - PodcasterPro"; 
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
require_once '../php/database/db.php';

$user_avatar = '';

if (!empty($user_id)) {  
    $query = "SELECT avatar FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Ошибка в подготовке запроса: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $stmt->bind_result($user_avatar);
    $stmt->fetch();
    
    $stmt->close();
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php include '../php/page_templates/head.php'; ?>
<body>

    <main id="page-content">
        <?php include '../index/index_account.html'; ?>
        <script>
            <?php include '../js/view_favorites.js'; ?>
        </script>
    </main>
    <?php include '../php/page_templates/header.php'; ?>

    <script>
        const userFavorites = <?php echo json_encode($isFavorite); ?>;
    </script>
    <script> 
        <?php include "../js/upload_avatar.js" ?>
    </script>
    <style> 
        <?php include '../css/style_account.css'; ?>
        <?php include '../css/page_template_styles/style_header.css'; ?>
        <?php include '../css/page_template_styles/style_auth.css'; ?>
    </style>
</body>
</html>
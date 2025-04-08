<?php
session_start();    
$title = "Страница пользователя - PodcasterPro"; 
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
require_once '../php/database/db.php';

// Получаем ID пользователя из URL (если он есть)
$profile_user_id = isset($_GET['id']) ? $_GET['id'] : $user_id;  // Если id нет в URL, показываем текущего пользователя

// Флаг для проверки, является ли текущий профиль чужим
$isOwnProfile = $user_id == $profile_user_id;

// Получаем аватар пользователя (текущего или чужого)
$user_avatar = '';
$query = "SELECT avatar FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Ошибка в подготовке запроса: " . $conn->error);
}

$stmt->bind_param("i", $profile_user_id);
$stmt->execute();

$stmt->bind_result($user_avatar);
$stmt->fetch();

$stmt->close();

// Проверяем, какие жанры в избранном у выбранного пользователя
$isFavoriteGenres = [];

$query = "SELECT g.id, g.name FROM favorite_genres f_g JOIN genres g ON f_g.genre_id = g.id WHERE f_g.user_id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Ошибка в подготовке запроса: " . $conn->error);
}

$stmt->bind_param("i", $profile_user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $isFavoriteGenres[] = $row;
    }
} else {
    die("Ошибка выполнения запроса: " . $stmt->error);
}

$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<?php include '../php/page_templates/head.php'; ?>
<body>
    <main id="page-content">
        <?php include '../index/index_account.html'; ?>
        <?php include '../index/audio_player.html';?>

        <!-- Делаем элементы управления доступными только если это собственный профиль -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isOwnProfile = <?php echo json_encode($isOwnProfile); ?>;

                // Если это чужой профиль, блокируем кнопки взаимодействия
                if (!isOwnProfile) {
                    // Блокируем кнопки "В избранное" и другие элементы взаимодействия
                    document.querySelectorAll('.control-btn').forEach(button => {
                        button.disabled = true;
                    });
                    
                    // Можно скрыть или отключить другие элементы, которые позволяют редактировать профиль или добавлять контент
                    document.querySelectorAll('.upload-label').forEach(button => {
                        button.style.display = 'none';  // Скрыть кнопки редактирования
                    });
                    document.querySelectorAll('.player-container .control-btn').forEach(button => {
                button.disabled = false;  // Убираем блокировку на кнопки плеера
            });
                }

            });
        </script>
        
        <script>
            <?php include '../js/view_favorites.js'; ?>
        </script>
        <script>
            <?php include '../js/get_all_favorite_genres.js'; ?>
        </script>
        <script>
            <?php include '../js/favorite_channel.js'; ?>
        </script>
    </main>
    <?php include '../php/page_templates/header.php'; ?>

    <script>
        const userFavorites = <?php echo json_encode($isFavoriteGenres); ?>;
    </script>
    <script> 
        <?php include "../js/upload_avatar.js" ?>
    </script>
    <style> 
        <?php include '../css/style_account.css'; ?>
        <?php include '../css/page_template_styles/style_header.css'; ?>
        <?php include '../css/page_template_styles/style_auth.css'; ?>
        <?php include '../css/page_template_styles/style_audio_player.css'; ?>
    </style>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

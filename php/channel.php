<?php
session_start();
require_once '../php/database/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Получаем список пользователей
$sql = "SELECT id, name, avatar FROM users WHERE id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователи</title>
    <link rel="stylesheet" href="../css/style_channel.css">
</head>
<body>
    <div class="container">
        <h2>Список пользователей</h2>
        <div class="users-list">
            <?php foreach ($users as $user): ?>
                <div class="user-card" data-id="<?= $user['id'] ?>">
                    <img src="uploads/<?= htmlspecialchars($user['avatar']) ?>" alt="<?= htmlspecialchars($user['name']) ?>">
                    <h3><?= htmlspecialchars($user['name']) ?></h3>
                    <button class="favorite-btn">⭐ В избранное</button>
                    <a href="../account?id=<?= $user['id'] ?>" class="view-profile">Перейти</a>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="../js/favorite_channel.js"></script>
</body>
</html>

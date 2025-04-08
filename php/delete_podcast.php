<?php
session_start();
require_once 'database/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $user_id = $_SESSION['user_id'];

    // Получаем подкасты пользователя
    $sql = "SELECT * FROM podcast WHERE user_id = ?"; 
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        throw new Exception("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Получаем имя пользователя
    $user_name = null;
    $sql_user = "SELECT name FROM users WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);

    if ($stmt_user) {
        $stmt_user->bind_param("i", $user_id);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        
        if ($row = $result_user->fetch_assoc()) {
            $user_name = htmlspecialchars($row['name']); // Защита от XSS
        }
    }
} catch (Exception $e) {
    die("Ошибка: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление подкастами</title>
    
    <!-- Подключение CSS -->
    <link rel="stylesheet" href="../css/delete.css">
    <link rel="stylesheet" href="../css/page_template_styles/style_header.css">
    <link rel="stylesheet" href="../css/page_template_styles/style_auth.css">
</head>
<body>

    <!-- Подключение шапки -->
    <?php include '../php/page_templates/header.php'; ?>

    <div class="container">
        <h2 class="name">Ваши подкасты</h2>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message success"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="podcast-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($podcast = $result->fetch_assoc()): ?>
                    <div class="podcast-item">
                        <span class="podcast-title"><?= htmlspecialchars($podcast['title']) ?></span>
                        <form action="delete_podcast_handler.php" method="POST">
                            <input type="hidden" name="podcast_id" value="<?= $podcast['id'] ?>">
                            <button type="submit" class="delete-btn">Удалить</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-podcasts">У вас пока нет подкастов.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Подключение JavaScript -->
    <script src="../js/script_login_register.js"></script>
    <script src="../js/check_account.js"></script>

</body>
</html>

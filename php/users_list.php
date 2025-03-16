<?php
session_start();
require '../php/database/db.php';

$title = "Каналы - PodcasterPro"; 
$user_name = $_SESSION['user_name'] ?? '';

// Получаем список пользователей
try {
    $stmt = $pdo->query("SELECT id, username, email FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Ошибка загрузки пользователей: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ru">
<?php include '../php/page_templates/head.php'; ?>

<body>
    <?php include '../php/page_templates/header.php'; ?>

    <main>
        <h1>Список пользователей</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php elseif (!empty($users)): ?>
            <ul class="users-list">
                <?php foreach ($users as $user): ?>
                    <li class="user-item">
                        <div class="user-info">
                            <strong>Имя:</strong> <?= htmlspecialchars($user['username']) ?>
                        </div>
                        <div class="user-info">
                            <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="empty-message">Пользователи не найдены.</p>
        <?php endif; ?>

        <?php include '../php/page_templates/auth.php'; ?>
    </main>

    <script src="../js/script_login_register.js"></script>
    <script src="../js/check_account.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <style> 
        <?php include '../css/style_channel.css'; ?>
        <?php include '../css/page_template_styles/style_header.css'; ?>
        <?php include '../css/page_template_styles/style_auth.css'; ?>
        
        .users-list {
            list-style: none;
            padding: 0;
            max-width: 600px;
            margin: 20px auto;
        }

        .user-item {
            background: #f5f5f5;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .user-info {
            margin: 5px 0;
        }

        .empty-message {
            text-align: center;
            color: #666;
            margin: 20px 0;
        }

        .error {
            color: #dc3545;
            padding: 15px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin: 20px;
            text-align: center;
        }
    </style>
</body>
</html>
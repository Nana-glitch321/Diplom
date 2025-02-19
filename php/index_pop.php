<?php
    session_start();
    $title = "Популярное - PodcasterPro"; 
    $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
    require_once '../php/database/db.php';

    $sql = "SELECT * FROM Podcast ORDER BY created_at DESC LIMIT 5";
    $result = $conn->query($sql);

    // Сохраняем подкасты в массив для вывода
    $podcasts = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $podcasts[] = $row;
        }
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="ru">
    <?php include '../php/page_templates/head.php'; ?>
    <body>
        <?php include '../php/page_templates/header.php'; ?>
        <main>
            <?php include '../index/index_pop.html' ?>
            
            <div class="podcast-list" style="margin: 250px">
                <?php 
                    // Включаем файл podcast.php для каждого подкаста
                    foreach ($podcasts as $podcast):
                        include '../php/page_templates/podcast.php';
                    endforeach;
                ?>
            </div>
        </main>
        <?php include '../php/page_templates/auth.php'; ?>

        <script src="../js/script_login_register.js"></script>
        <script src="../js/check_account.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <style> 
            <?php include '../css/style_pop.css' ?>
            <?php include '../css/page_template_styles/style_header.css' ?>
            <?php include '../css/page_template_styles/style_auth.css' ?>
        </style>
    </body>
</html>

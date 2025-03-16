<?php
    session_start();
    include '../php/database/db.php';

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Запрос на получение всех любимых жанров пользователя
        $query = "SELECT g.id, g.name, g.image_url FROM genres g
                JOIN favorite_genres fg ON g.id = fg.genre_id
                WHERE fg.user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Создаем массив любимых жанров
        $genres = [];
        while ($row = $result->fetch_assoc()) {
            $genres[] = $row;
        }

        // Возвращаем данные о жанрах в формате JSON
        echo json_encode($genres);
    } else {
        echo json_encode([]);
    }
?>

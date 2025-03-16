<?php
session_start();
include '../php/database/db.php';

if (isset($_POST['genre_id']) && isset($_POST['user_id'])) {
    $genre_id = (int)$_POST['genre_id'];
    $user_id = (int)$_POST['user_id'];

    // Проверяем, что жанр уже добавлен в избранное
    $checkQuery = "SELECT * FROM favorite_genres WHERE user_id = ? AND genre_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $user_id, $genre_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Если жанр в избранном, то удаляем его
        $deleteQuery = "DELETE FROM favorite_genres WHERE user_id = ? AND genre_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("ii", $user_id, $genre_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Жанр удален из избранного']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ошибка при удалении из избранного']);
        }
    } else {
        // Если жанр не в избранном, добавляем его
        $insertQuery = "INSERT INTO favorite_genres (user_id, genre_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ii", $user_id, $genre_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Жанр добавлен в избранное']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Ошибка добавления в избранное']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Необходимые данные не переданы']);
}
?>

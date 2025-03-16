<?php
session_start();
include '../php/database/db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Запрос на получение всех жанров, добавленных в избранное
    $query = "SELECT genre_id FROM favorite_genres WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $favoriteGenres = [];
    while ($row = $result->fetch_assoc()) {
        $favoriteGenres[] = $row['genre_id'];
    }

    // Возвращаем данные в формате JSON
    echo json_encode($favoriteGenres);
} else {
    echo json_encode([]);
}
?>

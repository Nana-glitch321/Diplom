<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "podcasterpro";

if (!isset($_SESSION['user_id'])) {
    die("Ошибка: Требуется авторизация!");
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $author = $_POST['author'] ?? '';
    $genres = $_POST['genres'] ?? []; // Получаем массив жанров

    if (empty($title) || empty($author)) {
        die("Ошибка: Заполните обязательные поля (название и автор)");
    }

    $audioData = file_get_contents($_FILES['audio']['tmp_name']);
    $audioType = $_FILES['audio']['type'];
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $imageType = $_FILES['image']['type'];

    // Сначала добавляем подкаст
    $stmt = $conn->prepare("INSERT INTO podcast (user_id, title, description, author, audio_data, image_data, audio_type, image_type) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt->bind_param("isssssss", 
        $user_id, $title, $description, $author, 
        $audioData, $imageData, $audioType, $imageType
    );

    if ($stmt->execute()) {
        $podcast_id = $conn->insert_id; // Получаем ID добавленного подкаста

        // Добавляем жанры в связующую таблицу podcast_genre
        $stmt_genre = $conn->prepare("INSERT INTO podcast_genre (podcast_id, genre_id) VALUES (?, ?)");

        foreach ($genres as $genre_id) {
            $stmt_genre->bind_param("ii", $podcast_id, $genre_id);
            $stmt_genre->execute();
        }

        echo "Подкаст успешно добавлен!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }
}

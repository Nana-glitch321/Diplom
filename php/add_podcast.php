<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "podcasterpro";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проверяем все обязательные поля
    $required = ['title', 'description', 'author'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            die("Поле $field обязательно для заполнения.");
        }
    }

    // Проверяем загружены ли файлы
    if (!isset($_FILES['audio']) || $_FILES['audio']['error'] != UPLOAD_ERR_OK) {
        die("Ошибка загрузки аудиофайла.");
    }
    if (!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        die("Ошибка загрузки изображения.");
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $_POST['author'];

    // Читаем файлы
    $audioData = file_get_contents($_FILES['audio']['tmp_name']);
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $audioType = $_FILES['audio']['type'];
    $imageType = $_FILES['image']['type'];

    // Подготавливаем запрос
    $stmt = $conn->prepare("INSERT INTO Podcast (title, description, author, audio_data, image_data, audio_type, image_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $title, $description, $author, $audioData, $imageData, $audioType, $imageType);

    if ($stmt->execute()) {
        echo "Подкаст успешно добавлен!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Неверный метод запроса.";
}
?>
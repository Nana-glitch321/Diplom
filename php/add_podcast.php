<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "podcasterpro";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['audio']) && isset($_FILES['image'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Читаем файлы в бинарном виде
    $audioData = file_get_contents($_FILES['audio']['tmp_name']);
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $audioType = $_FILES['audio']['type'];
    $imageType = $_FILES['image']['type'];

    $stmt = $conn->prepare("INSERT INTO Podcast (title, description, audio_data, image_data, audio_type, image_type) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $description, $audioData, $imageData, $audioType, $imageType);

    if ($stmt->execute()) {
        echo "Подкаст успешно добавлен!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Пожалуйста, загрузите все файлы.";
}
?>

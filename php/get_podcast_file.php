<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "podcasterpro";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = intval($_GET['id']);
    $type = $_GET['type']; // 'audio' или 'image'

    $column_data = $type . "_data";
    $column_type = $type . "_type";

    $stmt = $conn->prepare("SELECT $column_data, $column_type FROM Podcast WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fileData, $fileType);
    
    if ($stmt->fetch()) {
        header("Content-Type: $fileType");
        echo $fileData;
    } else {
        http_response_code(404);
        echo "Файл не найден";
    }

    $stmt->close();
}
$conn->close();
?>

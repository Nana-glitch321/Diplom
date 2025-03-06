<?php
session_start();    

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "podcasterpro";

// Подключение к базе данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка на подключение
if ($conn->connect_error) {
    die(json_encode(['error' => 'Ошибка подключения к базе данных: ' . $conn->connect_error]));
}

// Проверяем, установлен ли user_id
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'Пользователь не авторизован']));
}

$user_id = $_SESSION['user_id'];

// Запрос для получения избранных подкастов
$sql = "
    SELECT p.id, p.title, p.image_data, p.image_type, p.author 
    FROM podcast p
    JOIN favorites f ON p.id = f.podcast_id
    WHERE f.user_id = ?
";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(['error' => 'Ошибка подготовки запроса: ' . $conn->error]));
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$podcasts = [];

while ($row = $result->fetch_assoc()) {
    $podcasts[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'image_data' => base64_encode($row['image_data']),
        'image_type' => $row['image_type'],
        'author' => $row["author"],
    ];
}

$stmt->close();
$conn->close();

// Устанавливаем заголовок JSON и отправляем корректный ответ
header('Content-Type: application/json');
echo json_encode(['podcasts' => $podcasts]);
?>

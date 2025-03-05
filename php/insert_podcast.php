<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['audio']) && isset($_FILES['image'])) {
        $audioFile = $_FILES['audio'];
        $imageFile = $_FILES['image'];
        
        // Чтение бинарных данных файлов
        $audioData = file_get_contents($audioFile['tmp_name']);
        $imageData = file_get_contents($imageFile['tmp_name']);
        
        // Определение типов файлов
        $audioType = $audioFile['type'];
        $imageType = $imageFile['type'];
        
        // Вставка данных в таблицу
        $conn = new mysqli('localhost', 'username', 'password', 'database');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $stmt = $conn->prepare("INSERT INTO Podcast (title, description, audio_data, image_data, audio_type, image_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $description, $audioData, $imageData, $audioType, $imageType);
        
        $title = $_POST['title'];
        $description = $_POST['description'];
        
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
?>
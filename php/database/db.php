<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "podcasterpro";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }
?>

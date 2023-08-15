<?php
// Подключение к базе данных
$host = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$conn = new mysqli($host, $username, $password, $dbname);

// Получение полного текста статьи из базы данных
$id = $_POST["id"];
$stmt = $conn->prepare("SELECT text FROM articles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($text);
$stmt->fetch();
$stmt->close();
echo $text;
$conn->close();

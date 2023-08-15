<?php
header("Content-Type: text/html; charset=utf-8");

// Подключение к базе данных
$host = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$conn = new mysqli($host, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

// Получаем HTML-код страницы с последними статьями на Habr
$html = file_get_contents("https://habr.com/");

// Создаем объект DOM из полученного HTML-кода
$dom = new DOMDocument();
@$dom->loadHTML($html);

// Получаем список статей со страницы
$articles = $dom->getElementsByTagName("article");

// Проходимся по списку статей и сохраняем их в базу данных
foreach ($articles as $article) {
    $title_element = $article->getElementsByTagName("h2")[0];
    $title = mysqli_real_escape_string($conn, $title_element->nodeValue);
    $url = mysqli_real_escape_string($conn, $title_element->getElementsByTagName("a")[0]->getAttribute("href"));
    $content = trim($article->getElementsByTagName("div")[0]->nodeValue);

    // Обрезаем текст статьи до 200 символов
    $shortText = substr($content, 0, 200) . "...";

    // Проверяем, что данная статья еще не сохранена в базе данных
    $sql = "SELECT * FROM articles WHERE title='$title' AND link='$url'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        $shortText = mysqli_real_escape_string($conn, $shortText);
        $content = mysqli_real_escape_string($conn, $content);
        $sql = "INSERT INTO articles (title, link, shortText, text) VALUES ('$title', '$url', '$shortText', '$content')";
        mysqli_query($conn, $sql);
    }
}

$success = mysqli_affected_rows($conn) > 0 ? true : false;

echo json_encode(array("success" => $success));

$conn->close();

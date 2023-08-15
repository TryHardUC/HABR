<?php
// Подключение к базе данных
$host = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$conn = new mysqli($host, $username, $password, $dbname);

// Получение списка статей из базы данных
$offset = $_POST["offset"];
$limit = $_POST["limit"];
$stmt = $conn->prepare("SELECT COUNT(*) FROM articles");
$stmt->execute();
$stmt->bind_result($totalArticles);
$stmt->fetch();
$stmt->close();
$stmt = $conn->prepare("SELECT id, title, link, SUBSTRING(text, 1, 200) FROM articles ORDER BY id DESC LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$stmt->bind_result($id, $title, $link, $shortText);
while ($stmt->fetch()) {
	echo '<div class="card mb-3">';
	echo '<div class="card-body">';
	echo '<h5 class="card-title"><a href="https://habr.com' . $link . '" target="_blank">' . $title . '</a></h5>';
	echo '<p class="card-text">' . $shortText . '</p>';
	echo '<button type="button" class="btn btn-primary full-text-btn" data-article-id="' . $id . '">Полный текст</button>';
	echo '</div>';
	echo '</div>';
}
$stmt->close();
echo '<input type="hidden" id="total-articles" value="' . $totalArticles . '">';
$conn->close();

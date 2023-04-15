<?php
$short_code = $_GET['c'];

// ищем ссылку в базе данных
$mysqli = new mysqli('127.0.0.1', 'root', '', 'new_task');
$stmt = $mysqli->prepare('SELECT url FROM links WHERE short_code = ?');
$stmt->bind_param('s', $short_code);
$stmt->execute();
$stmt->bind_result($url);
$stmt->fetch();
$stmt->close();

if ($url) {
    // перенаправляем на исходную ссылку
    header('Location: ' . $url);
    exit;
} else {
    // выводим ошибку, если ссылка не найдена
    echo 'Error: Link not found';
    exit;
}
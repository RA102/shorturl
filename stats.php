<?php

spl_autoload_register(function ($class_name) {
    $file_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    require_once $file_name;
});

use MyProject\UrlShortener;

$shortCode = trim($_SERVER['REQUEST_URI']);
$shortCode = substr($shortCode, 1);

$urlShortener = new UrlShortener();
$urlShortener->stats($shortCode);

$result = $urlShortener->selectShortCode();
$row = $result->fetch_assoc();
echo 'Ссылка: ' . $row['short_code'] . '<br>';
echo 'Кол-во переходов: ' . $row["click"] . '<br>';


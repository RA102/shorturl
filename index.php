<?php

spl_autoload_register(function ($class_name) {
    $file_name = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    require_once $file_name;
});

use MyProject\UrlShortener;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['url']) && $_POST['url'] !== '') {
        $url = trim($_POST['url']);
        $urlShortener = new UrlShortener();
        $result = $urlShortener->shorten($url);

        header('Location: http://' . $_SERVER['HTTP_HOST'] . "/" . $result['short_code']);
        exit;
    } else {
        header('Location: /');
    }

}

<?php
include 'response.php';
include 'models/news.php';

$params = [];

foreach ($_POST as $name => $value) {
    $params[$name] = $value;
}

$news = new News();
$newsItem = false;

if(!$news->exist(['title' => $params['title'], 'source' => $params['source']])){
    $newsItem = $news->create($news);
}

return success($newsItem);
?>

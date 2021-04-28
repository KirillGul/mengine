<?php
include 'elems/init.php';

if (isset($_GET['page'])) {
    $url = $_GET['page'];
} else {
    $url = '/';
}

function query ($link, $url) {
    $query = "SELECT * FROM pagesj WHERE url='$url'";
    $result = mysqli_query($link, $query) or die( mysqli_error($link) );
    //Преобразуем то, что отдала нам база в нормальный массив PHP $data:
    return mysqli_fetch_assoc($result);
}

$page = query($link, $url);

if (!$page) {
    $page = query($link, '404');
    header("HTTP/1.0 404 Not Found");
}

$title = $page['text'];
$content = $page['text'];

include 'elems/layout.php';

echo "<a href=\"admin/\">Перейти в админку</a>";

/*echo "<pre>";
var_dump($_SERVER['REQUEST_URI']);
//var_dump($url);
echo "</pre>";*/


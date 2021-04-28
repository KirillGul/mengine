<?php
include 'elems/init.php';

$content = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    header('Location: page.php?id='.$id); die();
}

function creatLink ($elem) {   
    if ($elem['url'] != '/') $url = '?id='.$elem['id'];
    else $url = '/';

    if ($_SERVER['REQUEST_URI'] == $url) $class = ' class="active"';
    else $class = '';
 
    return "<p><a href=\"$url\"$class>{$elem['title']}</a></p>";
 }

$query = "SELECT * FROM blog WHERE url!='404' ORDER BY date DESC";
$result = mysqli_query($link, $query) or die( mysqli_error($link) );
//Преобразуем то, что отдала нам база в нормальный массив PHP $data:
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

if (!$data) {
    $data = query($link, '404');
    header("HTTP/1.0 404 Not Found");
}

foreach ($data as $elem) {
    $content .= creatLink($elem);
}

$title = 'main';

include 'elems/layout.php';

/*echo "<pre>";
//var_dump($_SERVER['REQUEST_URI']);
var_dump($id);
echo "</pre>";*/


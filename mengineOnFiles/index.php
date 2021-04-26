<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

//include 'connectDB.php';

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'index';
}

$path = "pages/$page.php";
if (file_exists($path)) {
    $content = file_get_contents($path);
} else {
    $content = file_get_contents('pages/404.php');
    header ('HTTP/1.0 404 Not Found');
}

//выбор title
$reg = '#\{\{title:(.*)\}\}#';
if (preg_match($reg, $content, $match)) {
    $title = $match[1];
    
    //выбор content
    $content = trim(preg_replace($reg, '', $content));
} else {
    $title = '404';
}    

include 'layout.php';

/*echo "<pre>";
var_dump($a);
echo "</pre>";*/


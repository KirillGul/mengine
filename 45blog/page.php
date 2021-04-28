<?php
include 'elems/init.php';

$content = '';
$blog = '';
$title = '';

$id = $_GET['id'];

$query = "SELECT * FROM blog WHERE id='$id' ORDER BY date DESC";
$result = mysqli_query($link, $query) or die( mysqli_error($link) );
//Преобразуем то, что отдала нам база в нормальный массив PHP $data:
$row = mysqli_fetch_assoc($result);

$title = $row['title'];

$author = $row['author'];
$date = $row['date'];
$text = $row['text'];

$blog = "<a href=\"/\">Главная</a>";
$blog .= "<h1>$title</h1>";
$blog .= "<div>
   <span>$author</span>
   <span>$date</span>
</div>";
$blog .= "<p>$text</p>";


include 'elems/layout.php';
<?php
$query = "SELECT * FROM pagesj WHERE url!='404'";
$result = mysqli_query($link, $query) or die( mysqli_error($link) );
//Преобразуем то, что отдала нам база в нормальный массив PHP $data:
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

function creatLink ($elem) {
   
   if ($elem['url'] != '/') $url = '/?page='.$elem['url'];
   else $url = '/';

   if ($_SERVER['REQUEST_URI'] == $url) $class = ' class="active"';
   else $class = '';

   return "<a href=\"$url\"$class>{$elem['title']}</a>";
}

foreach ($data as $elem) {
   echo creatLink($elem);
}
?>
<?php
function creatLink ($elem) {

   $uri = trim(preg_replace('#(\?.*)?#', '', $_SERVER['REQUEST_URI']), '/');

   if (empty($uri)) {
      $uri = '/';
   }

   $href = $elem['url'];
   if ($href != '/')
      $href= "/$href/";

   if ($uri == $elem['url']) $class = ' class="active"';
   else $class = '';  

   return "<a href=\"$href\"$class>{$elem['title']}</a>";
}

$query = "SELECT * FROM pagesj WHERE url!='404'";
$result = mysqli_query($link, $query) or die( mysqli_error($link) );
//Преобразуем то, что отдала нам база в нормальный массив PHP $data:
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

foreach ($data as $elem) {
   echo creatLink($elem);
}
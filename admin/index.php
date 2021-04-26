<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

include '../connectDB.php';

function showPageTable ($link) {
    $query = "SELECT id, title, url FROM pagesj";
    $result = mysqli_query($link, $query) or die( mysqli_error($link) );
    //Преобразуем то, что отдала нам база в нормальный массив PHP $data:
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

    $table = "
        <table>
        <tr>
        <th>ID</th>
        <th>Title</th>
        <th>URL</th>
        <th>Edit</th>
        <th>Delete</th>
        </tr>";
    foreach ($data as $value) {
        $table .= "<tr>
            <td>{$value['id']}</td>
            <td>{$value['title']}</td>
            <td>{$value['url']}</td>
            <td><a href=\"\">edit</a></td>
            <td><a href=\"?del={$value['id']}\">del</a></td>
            </tr>";
    }
    return $table .= "</table>";
}

function deletePage ($link, $id) {
    $query = "DELETE FROM pagesj WHERE id='$id'";
    $result = mysqli_query($link, $query) or die( mysqli_error($link) );
    //Преобразуем то, что отдала нам база в нормальный массив PHP $data:
}

if (!empty($_GET['del'])) {
    deletePage($link, $_GET['del']);
}

$content = showPageTable($link);

$title = 'admin main page';

include 'layout.php';

echo "<pre>";
var_dump($_SERVER['REQUEST_URI']);
//var_dump($del);
echo "</pre>";


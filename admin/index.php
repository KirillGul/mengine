<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'on');

$content = '';
$title = 'admin main page';

$info = '';
if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
}

/*if (isset($_GET['edit'])) {
    header("Location: /admin/edit.php?id={$_GET['edit']}");
}*/

include '../connectDB.php';

function showPageTable ($link) {
    $query = "SELECT id, title, url FROM pagesj WHERE url!='404'";
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
            <td><a href=\"edit.php?id={$value['id']}\">edit</a></td>
            <td><a href=\"?del={$value['id']}\">del</a></td>
            </tr>";
    }
    return $table .= "</table>";
}

function deletePage ($link, $id) {
    $query = "SELECT * FROM pagesj WHERE id='$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $query = "DELETE FROM pagesj WHERE id='$id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));

        if($result) return true;
        else return false;

    } else return true;
}

if (!empty($_GET['del'])) {
    $isDelete = deletePage($link, $_GET['del']);

    if ($isDelete)
        $info = [
            'msg' => "Успешно удаленно",
            'status' => 'success'
        ];
    else
        $info = [
            'msg' => "Ошибка удаления",
            'status' => 'error'
        ];
}

$content = "<a href=\"add.php\">Добавить страницу</a>";
$content .= showPageTable($link);

include 'layout.php';

/*echo "<pre>";
var_dump($_SERVER['REQUEST_URI']);
//var_dump($del);
echo "</pre>";*/


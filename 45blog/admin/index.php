<?php
include 'elems/password.php';
include '../elems/init.php';

if (isset($_SESSION['auth']) AND $_SESSION['auth'] == TRUE) {
    $content = '';
    $title = 'admin main page';

    $info = '';
    if (isset($_SESSION['info'])) {
        $info = $_SESSION['info'];
    }

    function showPageTable ($link) {
        $query = "SELECT id, title, url FROM blog WHERE url!='404'";
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
        $query = "SELECT * FROM blog WHERE id='$id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        $data = mysqli_fetch_assoc($result);

        if ($data) {
            $query = "DELETE FROM blog WHERE id='$id'";
            $result = mysqli_query($link, $query) or die(mysqli_error($link));

            if($result) return true;
            else return false;

        } else return true;
    }

    if (!empty($_GET['del'])) {
        $isDelete = deletePage($link, $_GET['del']);

        if ($isDelete) {
            $_SESSION['info'] = [
                'msg' => "Успешно удаленно",
                'status' => 'success'
            ];
            header('Location: /admin/'); die();
        } else {
            $_SESSION['info'] = [
                'msg' => "Ошибка удаления",
                'status' => 'error'
            ];
        }
    }

    $content = "<p><a href=\"logout.php\">Выход</a> ";
    $content .= "<a href=\"add.php\">Добавить страницу</a></p>";
    $content .= showPageTable($link);

    include 'elems/layout.php';

    /*echo "<pre>";
    var_dump($_SERVER['REQUEST_URI']);
    //var_dump($del);
    echo "</pre>";*/
} else {
    header('Location: /admin/login.php'); die();
}


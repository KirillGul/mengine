<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'on');

include '../connectDB.php';

$info = '';
$content = '';
$titleValue = '';
$urlValue = '';
$textValue = '';

$title = 'admin add page';

function checkPage($link, $urlPOST) {
   $query = "SELECT COUNT(*) as count FROM pagesj WHERE url='$urlPOST'";
   $result = mysqli_query($link, $query) or die(mysqli_error($link));
   return mysqli_fetch_assoc($result)['count'];
}

function addPage($link, $titlePOST, $urlPOST, $textPOST) {
   $query = "INSERT INTO pagesj SET title='$titlePOST', url='$urlPOST', text='$textPOST'";
   mysqli_query($link, $query) or die(mysqli_error($link));
   return checkPage($link, $urlPOST);
}


if(isset($_POST['title'])) {
   $titlePOST = $_POST['title'];
   $titleValue = " value = '".$_POST['title']."'";
}
if(isset($_POST['url'])) {
   $urlPOST = $_POST['url'];
   $urlValue = " value = '".$_POST['url']."'";
}
if(isset($_POST['text'])) {
   $textPOST = $textValue = $_POST['text'];
}

if (!empty($titlePOST) AND !empty($urlPOST)) {
   if (checkPage($link, $urlPOST) == false) {
      $add = addPage($link, $titlePOST, $urlPOST, $textPOST);

      if ($add) {
         $_SESSION['info'] = [
            'msg' => "Успешно добавленно",
            'status' => 'success'
         ];
         header('Location: /admin');
      } else {
         $info = [
            'msg' => "Ошибка добавления",
            'status' => 'error'
         ];
      }
   } else {
      $info = [
         'msg' => "Такой URL существует",
         'status' => 'error'
      ];
   }
} else {
   $info = [
      'msg' => "Введите значения title, url, [text]",
      'status' => 'warning'
   ];
}

$content = "<form method=\"POST\">
title:<br><input name='title'$titleValue><br><br>
url:<br><input name='url'$urlValue><br><br>
text:<br><textarea name='text'>$textValue</textarea><br><br>
<input type='submit'>
</form>";

include 'layout.php';

/*echo "<pre>";
//var_dump($_SERVER['REQUEST_URI']);
var_dump($_REQUEST);
echo "</pre>";*/
?>


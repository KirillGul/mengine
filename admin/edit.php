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
$id = $_GET['id'];

$title = 'admin edit page';

function checkPage($link, $id) {
   $query = "SELECT COUNT(*) as count FROM pagesj WHERE $id[0]='$id[1]'";
   $result = mysqli_query($link, $query) or die(mysqli_error($link));
   return mysqli_fetch_assoc($result)['count'];
}

function updatePage($link, $titlePOST, $urlPOST, $textPOST, $id) {
   $query = "SELECT * FROM pagesj WHERE id='$id'";
   $result = mysqli_query($link, $query) or die(mysqli_error($link));
   $data = mysqli_fetch_assoc($result);

   if (empty($titlePOST)) $titlePOST = $data['title'];
   if (empty($urlPOST)) $urlPOST = $data['url'];
   if (empty($textPOST)) $textPOST = $data['text'];

   $query = "UPDATE pagesj SET title='$titlePOST', url='$urlPOST', text='$textPOST' WHERE id='$id'";
   $result = mysqli_query($link, $query) or die(mysqli_error($link));
}

if(checkPage($link, ['id' ,$id])) {
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

   
   if (!empty($urlPOST) AND checkPage($link, ['url' ,$urlPOST]) == TRUE) {
      $info = [
         'msg' => "Такой URL уже существует",
         'status' => 'error'
      ];
   } elseif (!empty($titlePOST) OR !empty($urlPOST) OR !empty($textPOST)) {

      updatePage($link, $titlePOST, $urlPOST, $textPOST, $id);
      
      $_SESSION['info'] = [
            'msg' => "Успешно отредактированно",
            'status' => 'success'
      ];
      header('Location: /admin');
   } else {
      $info = [
         'msg' => "Введите значения хотя бы одно значение title, url, text",
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
} else {
   $_SESSION['info'] = [
      'msg' => "Запрошенной страницы не существует",
      'status' => 'error'
   ];
   header('Location: /admin');
}

/*echo "<pre>";
//var_dump($_SERVER['REQUEST_URI']);
var_dump($_GET['id']);
echo "</pre>";*/
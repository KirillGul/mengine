<?php
include 'elems/password.php';
include '../elems//init.php';

if ($_SESSION['pass'] == $passwordAdmin) {
   $content = '';
   $id = $_GET['id'];

   $title = 'admin edit page';

   function checkPage($link, $id) {
      $query = "SELECT COUNT(*) as count FROM pagesj WHERE $id[0]='$id[1]'";
      $result = mysqli_query($link, $query) or die(mysqli_error($link));
      return mysqli_fetch_assoc($result)['count'];
   }

   function selectPageValue($link, $id) {
      $query = "SELECT * FROM pagesj WHERE id='$id'";
      $result = mysqli_query($link, $query) or die(mysqli_error($link));
      return mysqli_fetch_assoc($result);
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
   //////////////////////////////////////////////////////
      $arrValuePost = selectPageValue($link, $id);

      $titleValue = " value = '{$arrValuePost['title']}'";
      $urlValue = " value = '{$arrValuePost['url']}'";
      $textValue = $arrValuePost['text'];
   //////////////////////////////////////////////////////
      if(isset($_POST['title'])) {
         $titlePOST = mysqli_real_escape_string($link, $_POST['title']);
         $titleValue = " value = '$titlePOST'";
      }
      if(isset($_POST['url'])) {
         $urlPOST = mysqli_real_escape_string($link, $_POST['url']);
         $urlValue = " value = '$urlPOST'";
      }
      if(isset($_POST['text'])) {
         $textPOST = $textValue = mysqli_real_escape_string($link, $_POST['text']);
      }
   //////////////////////////////////////////////////////
      if (!empty($titlePOST) OR !empty($urlPOST) OR !empty($textPOST)) {
         if (!empty($urlPOST) AND checkPage($link, ['url' ,$urlPOST]) == TRUE AND $urlPOST != $arrValuePost['url']) {
            $_SESSION['info'] = [
               'msg' => "Такой URL уже существует",
               'status' => 'error'
            ];
         } else {
            updatePage($link, $titlePOST, $urlPOST, $textPOST, $id);
         
            $_SESSION['info'] = [
                  'msg' => "Успешно отредактированно",
                  'status' => 'success'
            ];
            header('Location: /admin/'); die();
         }
      } else {
         $_SESSION['info'] = [
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

      include 'elems/layout.php';
   } else {
      $_SESSION['info'] = [
         'msg' => "Запрошенной страницы не существует",
         'status' => 'error'
      ];
      header('Location: /admin/'); die();
   }

   /*echo "<pre>";
   //var_dump($_SERVER['REQUEST_URI']);
   var_dump($_GET['id']);
   echo "</pre>";*/
} else {
   echo $formPass;

   if (isset($_POST['password'])) {
      $_SESSION['pass'] = $_POST['password'];
  }
}
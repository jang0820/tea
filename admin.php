<?php  //新增帳號，使用google雲端硬碟的試算表製作UTF8編碼的csv檔，中文才不會出現亂碼
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 0) header("Location: login.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    echo $acc;
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8"); 
  }else{
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html  lang="zh-TW">
<head>
<meta charset="utf-8">
<title>管理者</title>
</head>
<body>
  <?php
    echo "<form action='admin-user-action.php' enctype='multipart/form-data' method='POST'>";//新增使用者
    echo "<a href ='csv/stu.csv'>下載新增學生帳號CSV範例檔</a>";//下載CSV範例檔
    echo "<div> <input type='file' name='user'></div>";//選擇檔案
    echo "<input type='submit' value='上傳使用者'></form><br>";//上傳使用者
  ?>
</body>
</html>
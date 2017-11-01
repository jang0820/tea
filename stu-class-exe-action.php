<?php
  session_start();
  if (empty($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 2) header("Location: login.php");
  if ($_POST['exe_id']) $cls_id=$_POST['exe_id']; else header("Location: stu-class.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");
  }
  
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<title>學生課程頁面</title>
<meta charset="utf-8">
</head>
<body>
  <?php
  if (isset($_FILES['exe'])) {
    echo $_POST['exe_id']."<br>";
    echo $_FILES['exe']['name']."<br>";
    echo $_FILES['exe']['tmp_name']."<br>";
    echo $_FILES['exe']['size']."<br>";
    echo $_FILES['exe']['type']."<br>";
  }
    mysqli_close($db); 
  ?>
</body>
</html>
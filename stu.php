<?php
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 2) header("Location: login.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");
    $sql = "SELECT * FROM stu_class , class WHERE stu_class.cls_id = class.cls_id and stu_class.acc="."'" . $acc . "'";//根據帳號查詢學生所修課程
    $r1 = mysqli_query($db, $sql); 
    mysqli_close($db); 
  } else {
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<title>學生頁面</title>
<meta charset="utf-8">
</head>
<body>
  <?php
    if (mysqli_num_rows($r1) > 0){
      for($i=0;$i<mysqli_num_rows($r1);$i++){
      	$row=mysqli_fetch_row($r1);
        echo "<a href='stu-class.php?cls_id=".$row[1]."'>".$row[3]."</a>";//列出課程
      	echo "<br>";
      }
    }
  ?>
</body>
</html>
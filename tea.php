<?php
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 1) header("Location: login.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");
    $sql = "SELECT cls_id,cls_name FROM class WHERE class.acc="."'" . $acc . "'";//根據帳號查詢教師所開課程
    $r1 = mysqli_query($db, $sql); 
    mysqli_close($db); 
  } else {
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<title>教師頁面</title>
<meta charset="utf-8">
</head>
<body>
  <?php
    if (mysqli_num_rows($r1) > 0){
      for($i=0;$i<mysqli_num_rows($r1);$i++){
      	$row=mysqli_fetch_row($r1);
        echo "<a href='tea-class.php?cls_id=".$row[0]."'>".$row[1]."</a><br>";//列出課程
      }
    }
  ?>
</body>
</html>
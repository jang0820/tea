<?php //學生修改密碼，接收來自stu-pw.php的資料
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 2) header("Location: login.php");
  if ($_POST['oldpass']) $oldpass=$_POST['oldpass']; else header("Location: stu-pw.php");
  if ($_POST['newpass1']) $newpass1=$_POST['newpass1']; else header("Location: stu-pw.php");
  if ($_POST['newpass2']) $newpass2=$_POST['newpass2']; else header("Location: stu-pw.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");
    $sql = "SELECT pass FROM user WHERE  acc="."'" . $acc . "'";//根據帳號查詢學生所修課程
    $r1 = mysqli_query($db, $sql);
    if (mysqli_num_rows($r1)>0){
      $row=mysqli_fetch_row($r1);
      $pass=$row[0];
    } 
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
    if ($oldpass==$pass && $newpass1 == $newpass2){
      $sql="UPDATE user SET pass='".$newpass1."' WHERE acc='".$acc."'";
      $r1 = mysqli_query($db, $sql);
      echo "更新成功<br>";
    }else{
      echo "密碼錯誤<br>";
      header("Location: stu-pw.php");
    }
    mysqli_close($db);
  ?>
</body>
</html>
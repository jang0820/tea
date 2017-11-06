<?php  //搜尋$_GET['cls_id']的科目，並依照列為「學號與測驗」列出該科所有測驗成績
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 1) header("Location: login.php");
  if ($_GET['cls_id']) $cls_id=$_GET['cls_id']; else header("Location: login.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");  
  }else {
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<title>教師課程頁面</title>
<meta charset="utf-8">
</head>
<body>
  <?php
    $sql = "SELECT C.acc,C.class,C.seat,C.name,A.exam_id,A.exam_name,B.score FROM exam As A,exam_result As B,user As C,stu_class As D WHERE A.cls_id='$cls_id' and A.exam_id=B.exam_id and D.cls_id=A.cls_id and D.acc=C.acc and B.acc=C.acc order by acc";//查詢所有的測驗單元名稱
    $r1=mysqli_query($db,$sql);
    if (mysqli_num_rows($r1) > 0){//新增至少一個測驗名稱
      echo "<table border=1><tr><td>學號</td><td>班級</td><td>座號</td><td>姓名</td><td>測驗編號</td><td>測驗名稱</td><td>成績</td></tr>";
      $num=mysqli_num_rows($r1);
      for($i=0;$i<$num;$i++){
        $row=mysqli_fetch_row($r1);
        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td></tr>";
      }
      echo "</table>";
    }
    mysqli_close($db); 
  ?>
</body>
</html>
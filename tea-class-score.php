<?php  //搜尋$_GET['cls_id']的科目，並依照列為學號，行為測驗名稱列出該科所有成績
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
    $sql = "SELECT stu_class.acc,user.class,user.seat,user.name FROM stu_class,user WHERE stu_class.cls_id='$cls_id' and user.acc=stu_class.acc";//查詢修課學生的資本資料
    $r1=mysqli_query($db,$sql);
    if (mysqli_num_rows($r1) > 0){//至少一個使用者修此課程
      echo "<table border=1><tr><td>學號</td><td>班級</td><td>座號</td><td>姓名</td>";
      $sql = "SELECT exam_id,exam_name FROM exam WHERE cls_id='$cls_id'";//查詢所有的測驗單元名稱
      $r2=mysqli_query($db,$sql);
      if (mysqli_num_rows($r2) > 0){//此課程至少有一個測驗
        $num2=mysqli_num_rows($r2);
        for($j=0;$j<$num2;$j++){
          $row2=mysqli_fetch_row($r2);
          $exam_id=$row2[0];//紀錄測驗的id
          echo "<td>$row2[1]</td>";//顯示測驗名稱
        }
      }
      echo "</tr>";
      $num1=mysqli_num_rows($r1);
      for($i=0;$i<$num1;$i++){
        $row1=mysqli_fetch_row($r1);//依序找出修課同學的基本資料
        $acc=$row1[0];
        $class=$row1[1];
        $seat=$row1[2];
        $name=$row1[3];
        echo "<tr><td>$acc</td><td>$class</td><td>$seat</td><td>$name</td>";
        $sql = "SELECT exam_id,exam_name FROM exam WHERE cls_id='$cls_id'";//查詢所有的測驗單元名稱
        $r2=mysqli_query($db,$sql);
        if (mysqli_num_rows($r2) > 0){//此課程至少有一個測驗
          $num2=mysqli_num_rows($r2);
          for($j=0;$j<$num2;$j++){//找出某個同學的所有測驗成績
            $row2=mysqli_fetch_row($r2);
            $exam_id=$row2[0];
            $sql = "SELECT score FROM exam_result WHERE acc='$acc' and exam_id='$exam_id'";//查詢成績
            $r3=mysqli_query($db,$sql);
            if (mysqli_num_rows($r3) > 0){//有測驗成績
              $row3=mysqli_fetch_row($r3);
              echo "<td>$row3[0]</td>";
            }else{
              echo "<td></td>";//沒有測驗成績
            }
          }
          echo "</tr>";
        }
      }
      echo "</table>";
    }
    mysqli_close($db); 
  ?>
</body>
</html>
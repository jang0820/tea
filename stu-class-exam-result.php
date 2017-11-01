<?php
  session_start();
  if (empty($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 2) header("Location: login.php");
  if (isset($_GET['exam_id'])) $exam_id=$_GET['exam_id']; else header("Location: stu-class-exam.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    //$exam_id='cs101_001';
    //$acc = 'stu';
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");
    $sql = "SELECT A.cls_name,B.exam_name,C.exam_sn,C.exam_qu,C.exam_op1,C.exam_op2,C.exam_op3,C.exam_op4,C.exam_ans,D.exam_s1,D.exam_s2,D.exam_s3,D.exam_s4,D.score FROM class as A,exam as B,exam_choice as C,exam_result as D WHERE A.cls_id=B.cls_id and B.exam_id = C.exam_id and B.exam_id = D.exam_id and B.exam_id='". $exam_id ."'and D.acc='".$acc. "' order by C.exam_sn";//列出所有題目
    $r1 = mysqli_query($db, $sql); 
  } else {
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<title>學生測驗結果頁面</title>
<meta charset="utf-8">
</head>
<body> 
<?php
  if (mysqli_num_rows($r1) > 0){
    for($i=1;$i<=mysqli_num_rows($r1);$i++){//列出答題是否正確
      $row=mysqli_fetch_row($r1);
      if ($i == 1) echo "<h1>「".$row[1]."」單元測驗</h1>";
      if ($row[8+$i] == $row[8]) {
        echo "<div>(正確)第".$row[2]."題  ".$row[3]."<br>答對，答案為「".$row[8]."」</div><br>";
      }
      else echo "<div>(錯誤)第".$row[2]."題  ".$row[3]."<br>你的答案為「".$row[8+$i]."」，正確答案為「".$row[8]."」</div><br>";
    }
    echo "成績為".$row[13]."<br>";
  }
  mysqli_close($db);
?>
</body>
</html>
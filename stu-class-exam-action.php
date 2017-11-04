<?php  //接收開啟$_POST['exam_id']的測驗卷結果
  session_start();
  if (empty($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 2) header("Location: login.php");
  if (isset($_POST['exam_id'])) $exam_id=$_POST['exam_id']; else header("Location: stu-class-exam.php");
  if (!isset($_POST['1']) || !isset($_POST['2'])  || !isset($_POST['3']) || !isset($_POST['4']))  header("Location: stu-class-exam.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");
    $sql = "SELECT A.cls_name,B.exam_name,C.exam_sn,C.exam_qu,C.exam_op1,C.exam_op2,C.exam_op3,C.exam_op4,C.exam_ans FROM class as A,exam as B,exam_choice as C WHERE A.cls_id=B.cls_id and B.exam_id = C.exam_id and B.exam_id='". $exam_id . "' order by C.exam_sn";//列出所有題目
    $r1 = mysqli_query($db, $sql); 
  } else {
    header("Location: login.php");
  }
  if (isset($_POST['stime'])) $stime=$_POST['stime'];
  $etime = date_create()->format('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<title>學生測驗結果頁面</title>
<meta charset="utf-8">
</head>
<body> 
<?php
  $sql = "SELECT class,seat,name FROM user  WHERE acc='$acc'";//找出使用者的班級姓名與座號
  $r2 = mysqli_query($db, $sql);
  $row=mysqli_fetch_row($r2);
  $class=$row[0];
  $seat=$row[1];
  $name=$row[2];
  echo "<div class='acc'>班級$class  座號$seat  姓名$name  帳號 $acc <a href='logout.php'>登出</a></div>";
  $score=0;
  if (mysqli_num_rows($r1) > 0){
    for($i=1;$i<=mysqli_num_rows($r1);$i++){//列出答題是否正確
      $row=mysqli_fetch_row($r1);
      if ($i == 1) echo "<h1>「".$row[1]."」單元測驗</h1>";
      if ($_POST[$i] == $row[8]) {
        echo "<div>(正確)第".$row[2]."題  ".$row[3]."<br>答對，答案為「".$row[8]."」</div><br>";
        $score+=25;
      }
      else echo "<div>(錯誤)第".$row[2]."題  ".$row[3]."<br>你的答案為「".$_POST[$i]."」，正確答案為「".$row[8]."」</div><br>";
    }
    echo "獲得".$score."分<br>";
  }
  $sql = "SELECT * FROM exam_result WHERE acc='".$acc."'and exam_id='".$exam_id."'";//檢查是否做過測驗
  $r2 = mysqli_query($db, $sql);
  if (mysqli_num_rows($r2) == 0){//如果沒有做過測驗
    $sql = "INSERT INTO exam_result (acc, exam_id, exam_s1, exam_s2, exam_s3, exam_s4, score, stime, etime) VALUES ('".$acc."','".$exam_id."','".$_POST['1']."','".$_POST['2']."','".$_POST['3']."','".$_POST['4']."','".$score."','".$stime."','".$etime."')";
    $r3 = mysqli_query($db, $sql);
  } else {//已經做過測驗
    echo "已經做過測驗，無法再做一次測驗<br>";
  } 
  mysqli_close($db);
?>
</body>
</html>
<?php //開啟測驗
  session_start();
  if (empty($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 2) header("Location: login.php");
  if ($_GET['exam_id']) $exam_id=$_GET['exam_id']; else header("Location: login.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");
    $sql = "SELECT A.cls_name,B.exam_name,C.exam_sn,C.exam_qu,C.exam_op1,C.exam_op2,C.exam_op3,C.exam_op4,C.exam_ans FROM class as A,exam as B,exam_choice as C WHERE A.cls_id=B.cls_id and B.exam_id = C.exam_id and B.exam_id="."'" . $exam_id . "' order by C.exam_sn";//找出測驗題目
    $r1 = mysqli_query($db, $sql); 
  } else {
    header("Location: login.php");
  }
  $stime = date_create()->format('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<title>學生測驗頁面</title>
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
  $sql = "SELECT * FROM exam_result WHERE acc='".$acc."'and exam_id='".$exam_id."'";//檢查是否已經做過
  $r2 = mysqli_query($db, $sql);
  $sql = "SELECT exam_name FROM exam WHERE exam_id='".$exam_id."'";//找出測驗標題
  $r3 = mysqli_query($db, $sql);
  $row= mysqli_fetch_row($r3);
  $exam_name=$row[0];
  if (mysqli_num_rows($r2) > 0){
    echo "已經做過測驗，無法再做一次測驗<br>查詢測驗結果";
    echo "<a href='stu-class-exam-result.php?exam_id=".$exam_id."'>".$exam_name."</a>";
  }else{
?>
<form method="post" action="stu-class-exam-action.php">    
<?php
  for($i=0;$i<mysqli_num_rows($r1);$i++){//列出題目
    $row=mysqli_fetch_row($r1);
      if ($i == 0) echo "<h1>「".$row[1]."」單元測驗</h1>";
        echo "<div>第".$row[2]."題  ".$row[3]."</div>";
        echo "<div><input type=radio value='".$row[4]."' name='".$row[2]."'>".$row[4]."<br>";
        echo "<input type=radio value='".$row[5]."' name='".$row[2]."'>".$row[5]."<br>";
        echo "<input type=radio value='".$row[6]."' name='".$row[2]."'>".$row[6]."<br>";
        echo "<input type=radio value='".$row[7]."' name='".$row[2]."'>".$row[7]."<br></div>";
      }
    echo "<input type='hidden' name='exam_id' value='".$exam_id."'>";
    echo "<input type='hidden' name='stime' value='".$stime."'>";
?>
<input type="submit" name="submit" value="送出"/>
</form>
<?php
  }
?>
</body>
</html>
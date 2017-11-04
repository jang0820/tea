<?php  //上傳測驗卷題目
//上傳$_GET['exam_id']的測驗題目
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 1) header("Location: login.php");
  if ($_GET['exam_id']) $exam_id=$_GET['exam_id']; else header("Location: login.php");
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
<title>上傳測驗卷題目</title>
<meta charset="utf-8">
</head>
<body>
  <?php
    $sql = "SELECT A.exam_id,A.exam_name,B.exam_sn,B.exam_qu,B.exam_op1,B.exam_op2,B.exam_op3,B.exam_op4,B.exam_ans FROM exam As A,exam_choice As B WHERE A.exam_id = B.exam_id and A.exam_id='".$exam_id."'";//查詢所有的測驗單元名稱
    $r1=mysqli_query($db,$sql); 
    if (mysqli_num_rows($r1) > 0){//至少一個測驗題
      echo "<table border=1><tr><td>測驗編號</td><td>測驗名稱</td><td>題號</td><td>題目</td><td>選項1</td><td>選項2</td><td>選項3</td><td>選項4</td><td>答案</td></tr>";
      $num=mysqli_num_rows($r1);
      for($i=0;$i<$num;$i++){
        $row=mysqli_fetch_row($r1);
        echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[3]."</td><td>".$row[4]."</td><td>".$row[5]."</td><td>".$row[6]."</td><td>".$row[7]."</td><td>".$row[8]."</td></tr>";
      }
      echo "</table>";
    }
    echo "<form action='tea-exam-choice-action.php' enctype='multipart/form-data' method='POST'>";//新增測驗單元名稱
    echo "<a href ='csv/exam-choice.csv'>下載測驗卷CSV範例檔</a>";//下載CSV範例檔
    echo "<div> <input type='file' name='exam'></div>";//選擇檔案
    echo "<input type='hidden' name='exam_id' value='".$exam_id."'>";//使用POST傳送exam_id給接收網頁
    echo "<input type='submit' value='上傳測驗卷題目'></form><br><br>";//上傳測驗卷題目

   
    mysqli_close($db); 
  ?>
</body>
</html>
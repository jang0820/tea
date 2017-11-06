<?php //新增測驗卷題目，接收來自tea-exam-choice.php的檔案
//php預設執行時間限制為30秒，修改php.ini的max_execution_time=0，表示沒有限制
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 1) header("Location: login.php");
  if ($_POST['exam_id']) $exam_id=$_POST['exam_id']; else header("Location: login.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");   
  } else {
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<title>管理者頁面</title>
<meta charset="utf-8">
</head>
<body>
<?php
  if (isset($_FILES['exam'])) {
    //echo $_FILES['exam']['name']."<br>";
    //echo $_FILES['exam']['tmp_name']."<br>";
    //echo $_FILES['exam']['size']."<br>";
    //echo $_FILES['exam']['type']."<br>";
    $sql = "DELETE FROM exam_choice WHERE exam_id='".$exam_id."'";//刪除$exam_id的測驗卷
    $r1=mysqli_query($db,$sql);
    if (($handle = fopen($_FILES['exam']['tmp_name'], "r")) !== FALSE) {
      $row=0;
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $row++;
        if ($row!=1){ //忽略標題列
          $sn=$row-1;
          $sql="INSERT INTO exam_choice VALUES('".$exam_id."','".$sn."','".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."')";//新增測驗卷題目
          //echo $sql;
          $r1=mysqli_query($db,$sql);
        }
      }
      fclose($handle);
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
      echo "新增測驗單元成功";
    }
  }
?>
</body>
</html>
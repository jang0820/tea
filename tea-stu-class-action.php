<?php //新增選課學生，接收來自tea-class.php的選課學生csv檔
//php預設執行時間限制為30秒，修改php.ini的max_execution_time=0，表示沒有限制
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 1) header("Location: login.php");
  if ($_POST['cls_id']) $cls_id=$_POST['cls_id']; else header("Location: login.php");
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
<title>教師頁面</title>
<meta charset="utf-8">
</head>
<body>
<?php
  if (isset($_FILES['class'])) {
    echo $_FILES['class']['name']."<br>";
    echo $_FILES['class']['tmp_name']."<br>";
    echo $_FILES['class']['size']."<br>";
    echo $_FILES['class']['type']."<br>";
    $sql = "DELETE FROM stu_class WHERE cls_id='".$cls_id."'";//刪除$cls_id的所有測驗
    $r1=mysqli_query($db,$sql);
    if (($handle = fopen($_FILES['class']['tmp_name'], "r")) !== FALSE) {
      $row=0;
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $row++;
        if ($row!=1){ //忽略標題列
          $sql="INSERT INTO stu_class VALUES('$data[0]','$cls_id')";//新增選課學生
          $r1=mysqli_query($db,$sql);
        }
      }
      fclose($handle);
      $sql = "SELECT acc,cls_id FROM stu_class WHERE cls_id='".$cls_id."'";//查詢所有的修課學生帳號
      $r1=mysqli_query($db,$sql);
      echo "<div class='exe'>";
      if (mysqli_num_rows($r1) > 0){//新增至少一個作業名稱
        echo "<table border=1><tr><td>帳號</td><td>課程編號</td></tr>";
        $num=mysqli_num_rows($r1);
        for($i=0;$i<$num;$i++){
          $row=mysqli_fetch_row($r1);
          echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
        }
        echo "</table>";
      }
      echo "新增選課學生成功";
    }
  }
?>
</body>
</html>
<?php  //開啟$_GET['cls_id']的課程，並接收該課程的作業
  session_start();
  if (empty($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 2) header("Location: login.php");
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
<title>學生課程頁面</title>
<meta charset="utf-8">
<style type="text/css">
  .acc{
    text-align:right;
    font-size: 20px;
  }
  .cls{
    color:green;
    font-size:30px;
    border:2px green solid;
    margin:20px 0;
  }
  .title{
    color:blue;
    font-size:24px;
  }
  .exam{
    border:2px red solid;
  }
  .exam ul{
    list-style-type: none;
  }
  .exam li{
    padding:5px;
    font-size:20px;
  }
  .form{
    margin:5px 20px;
    font-size:20px;
  }
  .exe{
    border:2px blue solid;
    margin:20px 0px;
  }
</style>
</head>
<body>
  <?php
  if (isset($_POST['exe_id'])) $exe_id=$_POST['exe_id'];//上傳作業或刪除作業
  if (isset($_POST['delexe']) && ($_POST['delexe'] == "刪除作業")) {
    if (isset($_POST['exe_id'])) {
      $exe_id=$_POST['exe_id'];
      $sql = "SELECT f_name FROM stu_exe WHERE acc='".$acc."' and exe_id='".$exe_id ."'";//刪除作業檔案
      $r1 = mysqli_query($db, $sql);
      $row = mysqli_fetch_row($r1);
      $f_name = $row[0];//檔案名稱
      unlink("exe\\".$acc."\\".$f_name);//刪除作業檔案
      $sql = "Delete FROM stu_exe WHERE acc='".$acc."' and exe_id='".$exe_id."'";//刪除作業的資料庫
      $r2 = mysqli_query($db, $sql);
      echo "刪除作業<br>";
      echo "<meta http-equiv='refresh' content='3' />";
    }
  }else if (isset($_FILES['exe'])) {//上傳作業
    $ext = pathinfo($_FILES['exe']['name'], PATHINFO_EXTENSION);
    $sql = "SELECT exe_name FROM exe WHERE exe_id='".$exe_id ."'";
    $r2 = mysqli_query($db, $sql);
    $row = mysqli_fetch_row($r2);
    $exe_name = $row[0];//作業名稱
    if(copy($_FILES['exe']['tmp_name'],"exe\\".$acc."\\".$acc."_".$exe_name.".".$ext)) {//將上傳檔案進行複製到exe\帳號\帳號_作業名稱.副檔名
      echo "作業上傳成功";
      unlink($_FILES['exe']['tmp_name']);//刪除暫存檔
      $sql = "SELECT exe_id,acc FROM stu_exe WHERE exe_id='".$exe_id ."' and acc='".$acc."'";
      $r2 = mysqli_query($db, $sql);
      $datetime = date_create()->format('Y-m-d H:i:s');//作業上傳時間
      if (mysqli_num_rows($r2) > 0){//已經上傳過       
        $sql = "UPDATE stu_exe SET f_name='".$acc."_".$exe_name.".".$ext."', f_time='".$datetime."' WHERE exe_id='".$exe_id ."' and acc='".$acc."'";//已經上傳過，更新 檔案上傳紀錄到資料庫
        $r3 = mysqli_query($db, $sql);
      }else{//沒有上傳過
        $sql = "INSERT INTO stu_exe VALUES('".$acc."','".$cls_id."','".$exe_id."','".$acc."_".$exe_name.".".$ext."','".$datetime."')";//沒有上傳過，新增檔案上傳紀錄到資料庫
        $r3 = mysqli_query($db, $sql);
      }
      echo "<meta http-equiv='refresh' content='3' />";
    }else{
      echo "作業上傳失敗";
    }
    /*echo $_POST['exe_id']."<br>";
    echo $_FILES['exe']['name']."<br>";
    echo $_FILES['exe']['tmp_name']."<br>";
    echo $_FILES['exe']['size']."<br>";
    echo $_FILES['exe']['type']."<br>";*/
  }
  $sql = "SELECT class,seat,name FROM user  WHERE acc='$acc'";//找出使用者的班級姓名與座號
  $r1 = mysqli_query($db, $sql);
  $row=mysqli_fetch_row($r1);
  $class=$row[0];
  $seat=$row[1];
  $name=$row[2];
  echo "<div class='acc'>班級$class  座號$seat  姓名$name  帳號 $acc <a href='logout.php'>登出</a></div>";
  //列出課程的所有測驗
  $sql = "SELECT cls_name,cls_des FROM class  WHERE cls_id="."'" . $cls_id . "'";//找出課程的名稱與說明
  $r1 = mysqli_query($db, $sql);
  $row=mysqli_fetch_row($r1);
  echo "<div class='cls'><div>".$row[0]."</div><div>".$row[1]."</div></div>";
  $sql = "SELECT class.cls_id,class.cls_name,exam.exam_id,exam.exam_name,class.cls_des FROM exam,class  WHERE exam.cls_id=class.cls_id and class.cls_id="."'" . $cls_id . "'";//列出課程的所有測驗
  $r1 = mysqli_query($db, $sql);
  if (mysqli_num_rows($r1) > 0){
    echo "<div  class='exam'><div class='title'>ch1到ch4線上單選題測驗</div><ul>";
    for($i=0;$i<mysqli_num_rows($r1);$i++){
      $row=mysqli_fetch_row($r1);
      echo "<li><a href='stu-class-exam.php?exam_id=".$row[2]."'>".$row[3]."</a></li>";//開啟測驗卷
    }
    echo "</ul></div>";
  }
  //顯示所有作業
  $sql = "SELECT exe_id,exe_name FROM exe WHERE cls_id='".$cls_id ."'";//顯示所有作業
  $r2 = mysqli_query($db, $sql);
  if (mysqli_num_rows($r2) > 0){
    echo "<div  class='exe'>";
    for($i=0;$i<mysqli_num_rows($r2);$i++){
      $row2=mysqli_fetch_row($r2);
      echo "<form class='form' action='stu-class.php?cls_id=".$cls_id."' enctype='multipart/form-data' method='POST'>";//上傳作業功能
      echo $row2[1];//顯示作業名稱
      $sql = "SELECT acc,exe_id,f_name FROM stu_exe WHERE exe_id='".$row2[0] ."' and acc='".$acc."'";//查詢作業是否上傳過
      $r3 = mysqli_query($db, $sql);
      if (mysqli_num_rows($r3) > 0){//作業已經上傳過，顯示作業連結
        $row3=mysqli_fetch_row($r3);
        echo "，已經上傳的作業"."<a href='exe/".$row3[0]."/".$row3[2]."'>".$row3[2]."</a><br>";
      }
      echo "<div> <input type='file' name='exe'></div>";//選擇檔案
      echo "<input type='hidden' name='exe_id' value='".$row2[0]."'>";//作業上傳後，使用目前網頁接收作業才知道作業id
      echo "<input type='submit' value='上傳作業'>    ";//上傳作業
      echo "<input type='submit' name='delexe' value='刪除作業'></form><br>";//上傳作業
    }
    echo "</div>";
  }
  mysqli_close($db); 
?>
</body>
</html>
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
  if (isset($_POST['exe_id'])) $exe_id=$_POST['exe_id'];//上傳作業
  if (isset($_FILES['exe'])) {
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
    }else{
      echo "作業上傳失敗";
    }
    /*echo $_POST['exe_id']."<br>";
    echo $_FILES['exe']['name']."<br>";
    echo $_FILES['exe']['tmp_name']."<br>";
    echo $_FILES['exe']['size']."<br>";
    echo $_FILES['exe']['type']."<br>";*/
  }
  //列出課程的所有測驗
  $sql = "SELECT class.cls_id,class.cls_name,exam.exam_id,exam.exam_name FROM exam,class  WHERE exam.cls_id=class.cls_id and class.cls_id="."'" . $cls_id . "'";//列出課程的所有測驗
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
      echo "<input type='submit' value='上傳作業'></form><br>";//上傳作業
    }
    echo "</div>";
  }
  mysqli_close($db); 
?>
</body>
</html>
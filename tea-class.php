<?php  //開啟$_GET['cls_id']的課程，並接收該課程的測驗清單、作業清單與修改學生選課清單
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
<style type="text/css">
  .acc{
    text-align:right;
    font-size: 20px;
  }
  .exam{
    border:2px red solid;
    font-size:20px;
    margin:40px 0px;
  }
  .form{
    margin:5px 20px;
    font-size:20px;
  }
  .form input{
    font-size:20px;
  }
  .exe{
    border:2px blue solid;
    font-size:20px;
    margin:40px 0px;
  }
  .stu{
    border:2px green solid;
    font-size:20px;
    margin:40px 0px;
  }
</style>
<title>教師課程頁面</title>
<meta charset="utf-8">
</head>
<body>
  <?php
    $sql = "SELECT name FROM user  WHERE acc='$acc'";//找出教師姓名
    $r1 = mysqli_query($db, $sql);
    $row=mysqli_fetch_row($r1);
    $name=$row[0];
    echo "<div class='acc'>帳號 $acc  姓名$name <a href='logout.php'>登出</a></div>";
    $sql = "SELECT exam_id,exam_name FROM exam WHERE cls_id='".$cls_id."'";//查詢所有的測驗單元名稱
    $r1=mysqli_query($db,$sql);
    echo "<div class='exam'>";
    if (mysqli_num_rows($r1) > 0){//新增至少一個測驗名稱
      echo "<table border=1><tr><td>測驗編號</td><td>測驗名稱</td><td>上傳測驗卷</td></tr>";
      $num=mysqli_num_rows($r1);
      for($i=0;$i<$num;$i++){
        $row=mysqli_fetch_row($r1);
        echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td><a href='tea-exam-choice.php?exam_id=".$row[0]."'>上傳本單元測驗卷</a></td></tr>";
      }
      echo "</table>";
    }
    echo "<form class='form' action='tea-exam-action.php' enctype='multipart/form-data' method='POST'>";//新增測驗單元名稱
    echo "<a href ='csv/exam.csv'>下載測驗單元名稱CSV範例檔</a>";//下載CSV範例檔
    echo "<div> <input type='file' name='exam'></div>";//選擇檔案
    echo "<input type='hidden' name='cls_id' value='".$cls_id."'>";//使用POST傳送cls_id給接收網頁
    echo "<input type='submit' value='上傳測驗單元名稱'></form>";//上傳測驗單元名稱
    echo "<a href='tea-class-score.php?cls_id=$cls_id'>查詢目前學生成績</a>";//依照學號列出所有成績在同一列
    echo "</div>";
    $sql = "SELECT exe_id,exe_name FROM exe WHERE cls_id='".$cls_id."'";//查詢所有的作業單元名稱
    $r1=mysqli_query($db,$sql);
    echo "<div class='exe'>";
    if (mysqli_num_rows($r1) > 0){//新增至少一個作業名稱
      echo "<table border=1><tr><td>作業編號</td><td>作業名稱</td></tr>";
      $num=mysqli_num_rows($r1);
      for($i=0;$i<$num;$i++){
        $row=mysqli_fetch_row($r1);
        echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
      }
      echo "</table>";
    }
    echo "<form class='form' action='tea-exe-action.php' enctype='multipart/form-data' method='POST'>";//新增作業
    echo "<a href ='csv/exe.csv'>下載作業單元名稱CSV範例檔</a>";//下載CSV範例檔
    echo "<div> <input type='file' name='exe'></div>";//選擇檔案
    echo "<input type='hidden' name='cls_id' value='".$cls_id."'>";//使用POST傳送cls_id給接收網頁
    echo "<input type='submit' value='上傳作業單元名稱'></form>";//上傳作業單元名稱
    echo "<a href='tea-class-exe.php?cls_id=$cls_id'>查詢目前學生作業繳交情形</a>";//依照學號列出所有作業在同一列
    echo "</div>";

    $sql = "SELECT acc,cls_id FROM stu_class WHERE cls_id='".$cls_id."'";//查詢所有的修課學生帳號
    $r1=mysqli_query($db,$sql);
    echo "<div class='stu'>";
    if (mysqli_num_rows($r1) > 0){//新增至少一個作業名稱
      echo "<table border=1><tr><td>帳號</td><td>課程編號</td></tr>";
      $num=mysqli_num_rows($r1);
      for($i=0;$i<$num;$i++){
        $row=mysqli_fetch_row($r1);
        echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
      }
      echo "</table>";
    }
    echo "<form class='form' action='tea-stu-class-action.php' enctype='multipart/form-data' method='POST'>";//新增學生選課清單
    echo "<a href ='csv/stu-class.csv'>下載學生選課清單CSV範例檔</a>";//下載CSV範例檔
    echo "<div> <input type='file' name='class'></div>";//選擇檔案
    echo "<input type='hidden' name='cls_id' value='".$cls_id."'>";//使用POST傳送cls_id給接收網頁
    echo "<input type='submit' value='上傳學生選課清單'></form>";//上傳學生選課清單
    echo "</div>";
    mysqli_close($db); 
  ?>
</body>
</html>
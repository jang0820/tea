<?php  //接收來自admin.php的新增學生帳號檔案，新增帳號與上傳作業資料夾 
//php預設執行時間限制為30秒，修改php.ini的max_execution_time=0，表示沒有限制
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 0) header("Location: login.php");
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
  if (isset($_FILES['user'])) {
    echo $_FILES['user']['name']."<br>";
    echo $_FILES['user']['tmp_name']."<br>";
    echo $_FILES['user']['size']."<br>";
    echo $_FILES['user']['type']."<br>";
    $sql = "DELETE FROM user WHERE acc LIKE '1%'";//刪除數字1開頭的使用者
    $r1=mysqli_query($db,$sql);
    if (($handle = fopen($_FILES['user']['tmp_name'], "r")) !== FALSE) {
      $row=0;
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $row++;
        if ($row!=1){ //忽略標題列
          $sql="INSERT INTO user VALUES('".$data[0]."','".$data[1]."','".$data[2]."','2','".$data[3]."','".$data[4]."','','')";//新增使用者
          $r1=mysqli_query($db,$sql);
          if (!is_dir("exe/".$data[0])) mkdir("exe/".$data[0]);
        }
      }
      fclose($handle);
      echo "新增使用者成功";
    }
  }
?>
</body>
</html>
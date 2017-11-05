<?php
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 1) header("Location: login.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");
    $sql = "SELECT cls_id,cls_name FROM class WHERE class.acc="."'" . $acc . "'";//根據帳號查詢教師所開課程
    $r1 = mysqli_query($db, $sql); 
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
    if (mysqli_num_rows($r1) > 0){
      for($i=0;$i<mysqli_num_rows($r1);$i++){
      	$row=mysqli_fetch_row($r1);
        echo "<a href='tea-class.php?cls_id=".$row[0]."'>".$row[1]."</a><br>";//列出課程
      }
    }
    
    if (isset($_POST['select']) &&  $_POST['select'] == "選取課程") {
      $cls_id=$_POST['cls_id'];
      echo "選取課程".$_POST['cls_id'];
      $_POST['select'] == "";
      $sql = "SELECT cls_id,cls_name,cls_des FROM class WHERE acc='$acc' and cls_id='$cls_id'";//根據帳號查詢教師所開課程
      $r1 = mysqli_query($db, $sql);
      if (mysqli_num_rows($r1) > 0){
        for($i=0;$i<mysqli_num_rows($r1);$i++){
          $row=mysqli_fetch_row($r1);
          $cls_id=$row[0];
          $cls_name=$row[1];
          $cls_des=$row[2];
        }
      }
    } 
  ?>
  <form method="post" action="">
    <select name="cls_id">
    <?php
    $sql = "SELECT cls_id,cls_name,cls_des FROM class WHERE class.acc="."'" . $acc . "'";//根據帳號查詢教師所開課程
    $r1 = mysqli_query($db, $sql);
    if (mysqli_num_rows($r1) > 0){
      for($i=0;$i<mysqli_num_rows($r1);$i++){
        $row=mysqli_fetch_row($r1);
        echo "<option value='$row[0]'>$row[1]</option>";//列出課程
      }
    }
    ?>
    </select>
    <input type="submit" name="select" value="選取課程"/>
    <div>
      <label>課程編號</label><input type="text" name="cls_id"/><?php if (isset($cls_id)) echo $cls_id; ?><br>
      <label>課程名稱</label><input type="text" name="cls_name"/><?php if (isset($cls_name)) echo $cls_name; ?><br>
      <label>課程敘述</label><input type="text" name="cls_des"/><?php if (isset($cls_des)) echo $cls_des; ?><br>
    </div><br>
    <input type="submit" name="edit" value="編輯課程"/>
  </form>
  <?php
    mysqli_close($db); 
  ?>
</body>
</html>
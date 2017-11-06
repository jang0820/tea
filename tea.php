<?php//教師模組最上層，新增、修改與刪除課程
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
        echo "<a href='tea-class.php?cls_id=".$row[0]."'>".$row[0].$row[1]."</a><br>";//列出課程
      }
    } 
    if (isset($_POST['select']) &&  $_POST['select'] == "選取課程") {//經由下拉選單選取課程
      $cls_id=$_POST['cls_id_s'];
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
    if (isset($_POST['save']) &&  $_POST['save'] == "儲存課程") {//更新或新增課程
      if (isset($_POST['cls_id_e'])&&isset($_POST['cls_name_e'])&&isset($_POST['cls_des_e'])){
        $cls_id=$_POST['cls_id_e'];
        $cls_name=$_POST['cls_name_e'];
        $cls_des=$_POST['cls_des_e'];
        $sql = "SELECT cls_id,cls_name,cls_des FROM class WHERE acc='$acc' and cls_id='$cls_id'";//查詢課程是否存在
        $r1 = mysqli_query($db, $sql);
        if (mysqli_num_rows($r1) > 0){//更新課程
          $sql = "UPDATE class SET cls_name='$cls_name',cls_des='$cls_des' WHERE acc='$acc' and cls_id='$cls_id'";//根據帳號查詢教師所開課程
          $r1 = mysqli_query($db, $sql);
        }else{//新增課程
          $sql = "INSERT INTO class VALUES('$cls_id','$cls_name','$cls_des','$acc')";//新增課程
          $r1 = mysqli_query($db, $sql);
          echo "<meta http-equiv='refresh' content='2' />";
        }
        $_POST['save'] == "";
      }  
    }
    if (isset($_POST['delete']) &&  $_POST['delete'] == "刪除課程") {//刪除課程
      if (isset($_POST['cls_id_e'])){
        $cls_id=$_POST['cls_id_e'];
        $sql = "SELECT cls_id,cls_name,cls_des FROM class WHERE acc='$acc' and cls_id='$cls_id'";//查詢課程是否存在
        $r1 = mysqli_query($db, $sql);
        if (mysqli_num_rows($r1) > 0){
          $sql = "DELETE FROM class WHERE acc='$acc' and cls_id='$cls_id'";//刪除課程
          $r1 = mysqli_query($db, $sql);
        }else{//找不到該課程
          echo "找不到課程編號為".$cls_id."的課程";
        }
        $_POST['delete'] == "";
        echo "<meta http-equiv='refresh' content='2' />";
      }  
    }
    if (isset($_POST['clear']) &&  $_POST['clear'] == "清空表單") {//清空表單
      $cls_id="";
      $cls_name="";
      $cls_des="";
      $_POST['clear'] == "";
    }
  ?>
  <form method="post" action="">
    <select name="cls_id_s">
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
      <label>課程編號</label><input type="text" name="cls_id_e" value="<?php if (isset($cls_id)) echo $cls_id;?>"><br>
      <label>課程名稱</label><input type="text" name="cls_name_e" value="<?php if (isset($cls_name)) echo $cls_name;?>"><br>
      <label>課程敘述</label><textarea name="cls_des_e" cols="50" rows="6"> <?php if (isset($cls_des)) echo $cls_des;?></textarea><br>
    </div><br>
    <input type="submit" name="save" value="儲存課程"/><input type="submit" name="delete" value="刪除課程"/><input type="submit" name="clear" value="清空表單"/>
  </form>
  <?php
    mysqli_close($db); 
  ?>
</body>
</html>
<?php//學生修改密碼表單
  session_start();
  if (!isset($_SESSION['prio'])) header("Location: login.php");
  if ($_SESSION['prio'] != 2) header("Location: login.php");
  if (isset($_SESSION["acc"]) ) { 
    $acc = $_SESSION["acc"];
    $db = mysqli_connect("localhost", "tea", "cococola");
    mysqli_select_db($db, "tea");
    mysqli_query($db,"SET CHARACTER SET UTF8");
    $sql = "SELECT pass,name,class,seat FROM user WHERE  acc="."'" . $acc . "'";//根據帳號查詢學生所修課程
    echo $sql;
    $r1 = mysqli_query($db, $sql); 
    mysqli_close($db); 
  } else {
    header("Location: login.php");
  }
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<title>學生頁面</title>
<meta charset="utf-8">
</head>
<body>
  <?php
    if (mysqli_num_rows($r1)>0){
      $row=mysqli_fetch_row($r1);
      $pass=$row[0];
      $name=$row[1];
      $class=$row[2];
      $seat=$row[3];
    }
  ?>
  <form method="post" action="stu-pw-action.php">
    <div>
      <label>帳號</label><label name="acc"><?php echo $acc ?></label><br>
      <label>姓名</label><label name="name"><?php echo $name ?></label><br>
      <label>班級</label><label name="class"><?php echo $class ?></label><br>
      <label>座號</label><label name="seat"><?php echo $seat ?></label><br>
      <label>請輸入舊密碼</label><input type="text" name="oldpass"/><br>
      <label>請輸入第一次新密碼</label><input type="password" name="newpass1"/><br>
      <label>請輸入第二次新密碼</label><input type="password" name="newpass2"/><br>
    </div><br>
    <input type="submit" name="submit" value="更改密碼"/>
  </form>
</body>
</html>
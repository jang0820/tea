<?php
session_start();
session_destroy();
header("Location:login.php"); 
?>
<!DOCTYPE html>
<html  lang="zh-TW">
<head>
<meta charset="utf-8">
<title></title>
</head>
<body>
<h1>登出中</h1>
</body>
</html>
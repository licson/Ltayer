<?php
session_start();
require '../core/require.php';
include('../database/database.php');
$admincheck=$db->select("user",array("username"=>$_SESSION['login_username']));
if($admincheck[0]["admin"]!="true"){ die("您沒有權限瀏覽設定頁面"); }
$username = $_POST['username'];
$password = $_POST['password'];
$admin = $_POST['admin'];
if ($admin!="true") {
  $admin="false";
}
$db->delete("user",array("id"=>$_GET["id"]));
$db->delete("setting",array("name"=>"win_".$_GET["username"]."_pos"));
?>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<link href="../css/webos.css" type="text/css" rel="stylesheet" />
<style>
body{
  width:50%;
  margin:0 auto;
    margin-top: 10px;
}
</style>
<div class="grid">
  <div class="alert alert-success">刪除完成</div>
<a href="index.php" class="btn btn-info">回到控制台</a>
</div>

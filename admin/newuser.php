<?php
session_start();
require '../require.php';
include('../database.php');
$username = $_POST['username'];
$password = $_POST['password'];
$db->insert(array("username"=>$username,"password"=>md5(sha1($password))),"user");
echo "帳號新增完成。";
?>
<?php
require(dirname(__FILE__) . '/../../core/require.php');
include(dirname(__FILE__) . '/../../database/database.php');

$admincheck = $db->select("user", array("username" => $_SESSION['login_username']));

if($admincheck[0]["admin"] != "true"){
	die("您沒有權限瀏覽設定頁面!");
}

$email = $_POST['email'];
$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];
$id = $_GET["id"];
$admin = $_POST['admin'];

$GLOBALS['db']->update('user', array('email' => $email), array('id' => $_GET["id"]));

if ($admin != "true") {
	$admin = "false";
}
$GLOBALS['db']->update('user', array('admin' => $admin), array('id' => $_GET["id"]));

if ($pass == NULL) {
	header("Location: modifyuser.php?con=0&id=$id");
	exit();
}

if($pass != NULL && $pass != $pass2){
	header("Location: modifyuser.php?con=1&id=$id");
	exit();
} else {
	$GLOBALS['db']->update('user', array('password' => md5(sha1($pass))), array('username' => $_SESSION['login_username']));
	header("Location: modifyuser.php?con=0&id=$id");
	exit();
}
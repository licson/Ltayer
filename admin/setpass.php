<?php
session_start();
require '../require.php';
include('../database.php');

$pass = $_POST['pass'];
$pass2 = $_POST['pass2'];

if($pass != $pass2){
	die("�K�X�����T�C");
}
else {
	$GLOBALS['db']->update('user',array('password' => md5(sha1($pass))), array('username' => $_SESSION['login_username']));
	die("�K�X�]�w�����C");
}
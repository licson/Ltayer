<?php
session_start();
//include some file
include('database/database.php');
include('core/function.php');

$username = $_POST['username'];
$password = $_POST['password'];
$res = login($username, $password);

switch($res){
	case 0:	
		header("Location: login.php?err=0");
	break;

	case 1:
		$_SESSION['login'] = true;
		$_SESSION['login_username'] = $username;
		if(preg_match("/(Android)|(i(Pod|Phone))|(Mobile)/i",$_SERVER['HTTP_USER_AGENT'])){
			header("Location: ./mobile/");
		}
		else {
			header("Location: ./");
		}
	break;
	
	default:
		header("Location: login.php?err=1");
	break;
}
<?php
if(!session_id()) session_start();

if(!isset($_SESSION["login"]) || !$_SESSION["login"]) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: login.php");
	exit();
}?>
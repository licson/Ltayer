<?php
if(!session_id()){
	session_start();
}

include('../appfunctions.php');
include('../db_connect.php');

$title = $_POST['title'];
$content = $_POST['content'];

$res = $DB->Insert(array(
	'user_name' => $_SESSION['login_username'],
	"name" => $title,
	"content" => $content,
	"created_at" =>  date("Y-m-d H:i:s"),
	"updated_at" => date("Y-m-d H:i:s")
), "notepad");

if($res == true){
	redirect_to('../index.php');
} else {
	echo 'Error';
}
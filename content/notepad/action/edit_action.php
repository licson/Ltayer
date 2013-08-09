<?php
include(dirname(__FILE__).'/../appfunctions.php');
//if(isset($_POST['submit']) && $_POST['submit'] != ""){
$title = $_POST['title'];
$content = $_POST['content'];
$id = $_POST['id'];
include(dirname(__FILE__).'/../db_connect.php');
$DB->Update("notepad",array(
	'user_name' => "admin",
	'name' => $title,
	'content' => $content,
	'updated_at' => date("Y-m-d H:i:s")
	),array('id' => $id ));
	redirect_to('../show.php?id='.$id);
?>
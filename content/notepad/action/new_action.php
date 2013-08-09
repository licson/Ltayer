<?php
include(dirname(__FILE__).'/../appfunctions.php');
//if(isset($_POST['submit']) && $_POST['submit'] != ""){
$title = $_POST['title'];
$content = $_POST['content'];
include(dirname(__FILE__).'/../db_connect.php');
$res = $DB->Insert(array(
	user_name => "Admin",
	name => $title,
	content => $content,
	created_at =>  date("Y-m-d H:i:s"),
	updated_at => date("Y-m-d H:i:s")

	),"notepad");
if($res == true){
	redirect_to('../index.php');

}else{
	echo 'Error';
}

?>
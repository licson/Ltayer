<?php
//if(isset($_POST['submit']) && $_POST['submit'] != ""){
include_once(dirname(__FILE__).'/../db_connect.php');
$file = $DB->Select("notepad",array('id' => $id));
//echo $file[0]['created_at'];
//date("Y-m-d H:i:s", $file[0]['created_at']);
?>
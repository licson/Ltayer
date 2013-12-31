<?php
//include(dirname(__FILE__).'/../appfunctions.php');
include_once(dirname(__FILE__).'/../db_connect.php');
$file = $DB->Select("notepad");

if(isset($file[0])){
	$last = count($file);
}else{
	$last = 1;
}
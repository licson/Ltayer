<?php
require_once('../../require.php');
require_once('../../database.php');

if(isset($_GET['f'])){
	$file = $_GET['f'];
	$GLOBALS['db']->delete('file',array('real_location' => str_replace('file/','',$file)));
	unlink($file);
	die("刪除完成");
}
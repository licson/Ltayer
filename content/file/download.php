<?php
if(isset($_GET['f'],$_GET['orig'])){
	$file = $_GET['f'];
	$orig = $_GET['orig'];

	header('Content-disposition: attachment; filename='.$orig);
	@readfile($file);
	ob_flush();
	flush();
}
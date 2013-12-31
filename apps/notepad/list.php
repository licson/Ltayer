<?php
if(isset($_GET) && $_GET != ""){
	$action = $_GET['a'];
}

include('action/list_action.php');
load_template("_header");
include('templates/list.tpl.php');
load_template("_footer");
//echo '<a href="index.php">Back To Editor</a>';
?>
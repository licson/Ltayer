<?php
function isXTR(){
	 return isset($_server['http_x_requested_with']);
}
function connect(){
	include_once(dirname(__FILE__).'/db_connect.php');

}
function load_template($name){
	include('templates/'.$name.'.tpl.php');
}
function redirect_to($url){
	  header('Location:'.$url);
}

?>
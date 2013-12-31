<?php
function login($username,$password){
	$password=md5(sha1($password));
	$res = $GLOBALS['db']->select('user',array('username'=>$username,'password'=>$password));
	return is_array($res);
}

function url($path){
	if(preg_match('/^https?/', $path)){
		echo './app_proxy.php?url=' . $path;
	}
	else {
		echo $path;
	}
}
 <?php
//include some file
include('database.php');
//---------------Start to write the sql function------------------
function login($username,$password){
	$password=md5(sha1($password));
	$res = $GLOBALS['db']->select('user',array('username'=>$username,'password'=>$password));
	return is_array($res);
}
function url($path){
	if(preg_match('/^https?/',$path)){
		echo $path;
	}
	else {
		echo $path;
	}
}
?>
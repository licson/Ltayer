<?php
require(dirname(__FILE__) . '/../../core/require.php');
include(dirname(__FILE__) . '/../../database/database.php');

function url($path){
	if(preg_match('/^https?/',$path)){
		echo '../app_proxy.php?url=' . urlencode($path) . '&mobile=1';
	}
	else {
		echo '../' . $path;
	}
}

$res = $db->select("setting",array("name"=>"system_name"));
$title = $res[0]["value"];

$admincheck = $db->select("user",array("username" => $_SESSION['login_username']));

if($admincheck[0]["admin"] != "true"){
	die("您沒有權限瀏覽設定頁面!");
}

$username = $_POST['username'];
$password = $_POST['password'];
$admin = $_POST['admin'];

if ($admin != "true") {
	$admin = "false";
}

$db->insert(array(
	"username" => $username,
	"password" => md5(sha1($password)),
	"admin" => $admin
),"user");
?>
<!doctype html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="http://ajax.aspnetcdn.com/ajax/jquery.mobile/1.3.1/jquery.mobile-1.3.1.min.css" type="text/css" rel="stylesheet" />
        <script src="../../js/jquery-1.9.1.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	</head>
	<body>
        <div data-role="page" id="main">
			<div data-role="panel" data-theme="c" id="panel">
				<ul data-role="listview" data-divider-theme="a">
					<li data-role="list-divider">基本</li>
					<li><a href="../">回到主頁<a></li>
					<li><a href="<?php url('logout.php'); ?>" data-ajax="false">登出</a></li>
				</ul>
			</div>
            <div data-role="header" data-theme="d" data-position="fixed">
				<a href="#panel" data-role="button" data-icon="bars" data-iconpos="notext" data-shadow="true"></a>
                <h1><?php echo $title; ?></h1>
            </div>
            <div data-role="content" id="pane">
                <img src="../../img/ltayer.png" alt="<?php echo $title; ?>" style="display: block; margin: 1.5em auto;" />
				<p>用戶新增完成!</p>
				<a href="./" data-role="button">返回</a>
    		</div>
        </div>
	</body>
</html>
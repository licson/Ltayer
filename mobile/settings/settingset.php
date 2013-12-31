<?php
require(dirname(__FILE__) . '/../../core/require.php');
include(dirname(__FILE__) . '/../../database/database.php');

$admincheck = $db->select("user", array("username" => $_SESSION['login_username']));

if($admincheck[0]["admin"] != "true"){
	die("您沒有權限瀏覽設定頁面");
}

function Updateconfig($config, $name){
	$GLOBALS['db']->update('setting',array('value' => $config),array('name' => $name));
}

Updateconfig($_POST['bg'], 'bg');
Updateconfig($_POST['system_name'], 'system_name');
Updateconfig($_POST['dock'], 'dock');
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
            <div data-role="header" data-theme="d" data-position="fixed">
                <h1>修改完成!</h1>
            </div>
            <div data-role="content" id="pane">
				<p>設定修改完成!</p>
				<a href="./" data-role="button">返回</a>
			</div>
		</div>
	</body>
</html>
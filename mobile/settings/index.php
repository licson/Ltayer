<?php
require(dirname(__FILE__) . '/../../core/require.php');
include(dirname(__FILE__) . '/../../database/database.php');

$admincheck = $db->select("user",array("username" => $_SESSION['login_username']));

$res = $db->select("setting",array("name" => "system_name"));
$title = $res[0]["value"];

function url($path){
	if(preg_match('/^https?/',$path)){
		echo '../app_proxy.php?url=' . urlencode($path) . '&mobile=1';
	}
	else {
		echo '../' . $path;
	}
}
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
					<li><a href="../">主頁</a></li>
					<li><a href="<?php url('logout.php'); ?>" data-ajax="false">登出</a></li>
				</ul>
			</div>
            <div data-role="header" data-theme="d" data-position="fixed">
				<a href="#panel" data-role="button" data-icon="bars" data-iconpos="notext" data-shadow="true"></a>
                <h1>控制台 - <?php echo $title; ?></h1>
            </div>
            <div data-role="content" id="pane">
                <img src="../../img/ltayer.png" alt="<?php echo $title; ?>" style="display: block; margin: 1.5em auto;" />
				<?php if($admincheck[0]["admin"] != "true"){ ?>
				<p>您沒有權限瀏覽設定頁面!</p>
				<?php } else { ?>
				<ul data-role="listview" data-inset="true">
					<li data-role="list-divider" data-theme="d">用戶</li>
					<li><a href="showuser.php" data-rel="dialog">管理用戶</a></li>
					<li><a href="#add_user" data-rel="dialog">新增用戶</a></li>
					<li data-role="list-divider" data-theme="d">系統</li>
					<li><a href="#system_settings" data-rel="dialog">介面設定</a></li>
				</ul>
				<?php } ?>
    		</div>
        </div>
		
		<div data-role="page" id="add_user">
			<div data-role="header" data-theme="d" data-position="fixed">
				<h1>新增帳號</h1>
			</div>
			<div data-role="content" data-theme="c">
                <form action="newuser.php" method="post">
                    <input type="text" name="username" id="username" placeholder="帳號" />
                    <input type="text" name="password" id="password" placeholder="密碼" />
					
					<label for="admin">管理員權限</label>
					<select name="admin" id="admin" data-role="slider">
						<option value="false">否</option>
						<option value="true">是</option>
					</select>
                    <input type="submit" value="送出" />
                </form>
			</div>
		</div>
		<div data-role="page" id="system_settings">
			<div data-role="header" data-theme="d" data-position="fixed">
				<h1>系統設定</h1>
			</div>
			<div data-role="content" data-theme="c">
				<form action="settingset.php" method="post">
					<input type="text" name="bg" id="bg" value="<?php $res = $db->select("setting", array("name"=>"bg")); echo $res[0]["value"]; ?>" placeholder="背景圖片" />
					<input type="text" name="system_name" id="system_name" value="<?php $res = $db->select("setting", array("name" => "system_name")); echo $res[0]["value"]; ?>" placeholder="系統名稱" />
					<label for="dock">啟用Dock</label>
					<select name="dock" id="dock" data-role="slider">
						<option value="false">停用</option>
						<option value="true"<?php $res = $db->select("setting", array("name"=>"dock")); echo $res[0]["value"] ? " selected" : ''; ?>>啟用</option>
					</select>
					<input type="submit" value="送出" data-rel="dialog" />
				</form>
			</div>
		</div>
	</body>
</html>
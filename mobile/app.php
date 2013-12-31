<?php
require(dirname(__FILE__) . '/../core/require.php');
include(dirname(__FILE__) . '/../database/database.php');

function url($path){
	if(preg_match('/^https?/',$path)){
		echo '../app_proxy.php?url=' . urlencode($path) . '&mobile=1';
	}
	else {
		echo '../' . $path;
	}
}

$current = $db->select("app", array("id"=>$_GET['id']));
?>
<!doctype html>
<html>
	<head>
		<title><?php echo $current[0]['name']; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="http://ajax.aspnetcdn.com/ajax/jquery.mobile/1.3.1/jquery.mobile-1.3.1.min.css" type="text/css" rel="stylesheet" />
		<style>
			#app {
				height: 100%;
				padding: 0;
			}
		</style>
		<script src="../js/jquery-1.9.1.js"></script>
		<script src="js/webos.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	</head>
	<body>
        <div data-role="page" id="main">
			<div data-role="panel" data-theme="c" id="panel">
				<ul data-role="listview" data-divider-theme="a">
					<li data-role="list-divider">基本</li>
					<li><a href="./">主頁</a></li>
					<li><a href="./settings/">行動版設定</a></li>
					<li><a href="<?php url('logout.php'); ?>" data-ajax="false">登出</a></li>
					<!-- Apps -->
					<li data-role="list-divider">應用程式</li>
					<?php foreach($db->select("app") as $d){ ?>
					<li><a href="<?php url($d['canvas_url']); ?>" data-id="<?php echo $d['id']; ?>"><?php echo $d['name']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
            <div data-role="header" data-theme="d" data-position="fixed">
				<a href="#panel" data-role="button" data-icon="bars" data-iconpos="notext" data-shadow="true"></a>
                <h1><?php echo $current[0]['name']; ?></h1>
				<a href="./" data-role="button" data-icon="arrow-l" data-icon-position="left" data-mini="true">返回</a>
            </div>
    		<div data-role="content" id="app">
				<iframe style="border: none; width: 100%; height: 92.5%;" src="<?php url($current[0]['canvas_url']); ?>"></iframe>
    		</div>
        </div>
	</body>
</html>
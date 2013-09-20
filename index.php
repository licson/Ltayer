<?php
require('require.php');
include('database.php');

if(preg_match("/(Android)|(i(Pod|Phone))|(Mobile)/i",$_SERVER['HTTP_USER_AGENT'])){
	header("Location: ./mobile/");
}

function url($path){
	if(preg_match('/^https?/',$path)){
		echo $path;
	}
	else {
		echo $path;
	}
}

$res = $db->select("setting",array("name"=>"system_name"));
$title = $res[0]["value"];

$res = $db->select("setting",array("name"=>"bg"));
$bg = $res[0]["value"];
?>
<!doctype html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/jquery-ui-1.10.3.custom.min.css" type="text/css" rel="stylesheet" />
		<link href="css/webos.css" type="text/css" rel="stylesheet" />
		<style>
			body {
				background: url(<?php echo $bg; ?>) !important;
			}
		</style>
		<script src="js/jquery-1.9.1.js"></script>
		<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="js/jquery.ui.touch.min.js"></script>
		<script src="js/webos.js"></script>
	</head>
	<body>
		<div id="status-bar" class="user-header ui-helper-clearfix">
			<ul>
				<li data-role="logo"><span class="ui-icon ui-icon-home"></span></li>
				<li data-role="title"><?php echo $title; ?></li>
				<li><a href="logout.php">登出</a></li>
				<li class="pull-right"><a href="#" id="win_button">視窗</a></li>
			</ul>
			<ul id="wins">
				<li class="ignore">沒有視窗！</li>
			</ul>
		</div>
		<div id="pane">
			<ul id="shortcuts" class="ui-helper-clearfix">
				<?php foreach($db->select("app") as $d){ ?>
				<li><a href="<?php url($d['canvas_url']); ?>"><img src="<?php url($d['logo']); ?>" /><?php echo $d['name']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</body>
</html>
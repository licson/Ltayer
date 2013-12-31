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
		<link href="http://ajax.aspnetcdn.com/ajax/jquery.mobile/1.3.1/jquery.mobile-1.3.1.min.css" type="text/css" rel="stylesheet" />
		<style>
			body {
				background: url(<?php echo $bg; ?>) !important;
			}
			
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
					<li><a href="./settings/">行動版設定</a></li>
					<li><a href="<?php url('logout.php'); ?>" data-ajax="false">登出</a></li>
				</ul>
			</div>
            <div data-role="header" data-theme="d" data-position="fixed">
				<a href="#panel" data-role="button" data-icon="bars" data-iconpos="notext" data-shadow="true"></a>
                <h1><?php echo $title; ?></h1>
            </div>
    		<div data-role="content" id="pane">
    		    <img src="../img/ltayer.png" alt="<?php echo $title; ?>" style="display: block; margin: 1.5em auto;" />
    			<ul id="shortcuts" data-role="listview" data-theme="c" data-filter="true" data-filter-placeholder="搜尋應用程式..." data-inset="true">
					<?php foreach($db->select("app") as $d){ ?>
					<li>
				    	<a href="<?php url($d['canvas_url']); ?>" data-id="<?php echo $d['id']; ?>">
				        	<img src="<?php url($d['logo']); ?>" />
				        	<p><?php echo $d['name']; ?></p>
				        </a>
				    </li>
					<?php } ?>
    			</ul>
    		</div>
        </div>
	</body>
</html>
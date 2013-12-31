<?php
require_once('core/require.php');
require_once('database/database.php');

if(preg_match("/(Android)|(i(Pod|Phone))|(Mobile)/i",$_SERVER['HTTP_USER_AGENT'])){
	header("Location: ./mobile/");
}

function url($path){
	if(preg_match('/^https?/',$path)){
		echo 'app_proxy.php?url=' . urlencode($path);
	}
	else {
		echo $path;
	}
}

$res = $db->select("setting",array("name"=>"system_name"));
$title = $res[0]["value"];

$res = $db->select("setting",array("name"=>"bg"));
$bg = $res[0]["value"];

$res = $db->select("setting",array("name"=>"dock"));
$dock = $res[0]["value"];
?>
<!doctype html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link href="css/jquery-ui-1.10.3.custom.min.css" type="text/css" rel="stylesheet" />
		<link href="css/webos.css" type="text/css" rel="stylesheet" />
		<link href="css/ionicons.css" type="text/css" rel="stylesheet" />
		<link href="css/contextmenu.css" type="text/css" rel="stylesheet" />
		<style>
			body {
				background: #d8d8d8; /* Old browsers */
				background: -moz-linear-gradient(top,  #d8d8d8 0%, #ededed 50%, #d8d8d8 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#d8d8d8), color-stop(50%,#ededed), color-stop(100%,#d8d8d8)); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(top,  #d8d8d8 0%,#ededed 50%,#d8d8d8 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(top,  #d8d8d8 0%,#ededed 50%,#d8d8d8 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(top,  #d8d8d8 0%,#ededed 50%,#d8d8d8 100%); /* IE10+ */
				background: linear-gradient(to bottom,  #d8d8d8 0%,#ededed 50%,#d8d8d8 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d8d8d8', endColorstr='#d8d8d8',GradientType=0 ); /* IE6-9 */
				<?php if($bg!=NULL){ echo "background-image: url($bg) !important; background-repeat: no-repeat; background-size: cover; background-attachment:fixed; background-position: center;";} ?>
			}
		</style>
		<script src="js/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script src="js/jquery.ui.touch.min.js"></script>
		<script src="js/contextmenu.js"></script>
		<script src="js/ltayer.js"></script>
		<script src="js/dock.js"></script>
		<!--[if lte IE 7]>
		<style>
			/* Inline block fix */
			#dock ul {
				display: inline;
				zoom: 1;
			}

			#dock li, #dock li a {
				display: inline;
				zoom: 1;
			}

			/* Image quality fix */
			img {
				-ms-interpolation-mode: bicubic;
			}

			#dock li a span {
				filter: alpha(opacity=40);
			}
		</style>
		<![endif]-->
	</head>
	<body>
		<div id="status-bar" class="user-header ui-helper-clearfix">
			<ul>
				<li data-role="title"><a class="about"><img src="img/ltayer.png" alt="<?php echo $title; ?>" /></a></li>
				<li data-role="time"><a href="#"></a></li>
				<li class="pull-right"><a href="logout.php" id="ltayer-logout">登出</a></li>
			</ul>
		</div>
		<div id="pane">
			<ul id="shortcuts" class="ui-helper-clearfix">
				<?php foreach($db->select("app", '', 'pos ASC') as $d){ ?>
				<li data-app-id="<?php echo $d['app_key']; ?>" id="app_<?php echo $d['id']; ?>">
					<a href="<?php url($d['canvas_url']); ?>">
						<img src="<?php url($d['logo']); ?>" />
						<span><?php echo $d['name']; ?></span>
					</a>
				</li>
				<?php } ?>
			</ul></div>
			<?php if($dock == "true"){ ?>
			<div id="dock">
    			<ul id="dockicon">
        			<?php foreach($db->select("app", '', 'pos ASC') as $c){ ?>
        			<li><a href="<?php url($c['canvas_url']); ?>"><span><?php echo $c['name']; ?></span><img src="<?php url($c['logo']); ?>" /></a></li>
        			<?php } ?>
        			<li class="seperator"></li>
        			<li><a id="dock-logout"><span>登出</span><img src="img/icons/logout.png" /></a></li>
    			</ul>
			</div>
			<?php } ?>
	</body>
</html>
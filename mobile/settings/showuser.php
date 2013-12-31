<?php
require(dirname(__FILE__) . '/../../core/require.php');
include(dirname(__FILE__) . '/../../database/database.php');

$admincheck = $db->select("user",array("username" => $_SESSION['login_username']));

$res = $db->select("setting",array("name" => "system_name"));
$title = $res[0]["value"];

$res = $db->select("setting",array("name"=>"bg"));
$bg = $res[0]["value"];

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
		<style>
			body {
				background: url(<?php echo $bg; ?>) !important;
			}
			
			#app {
				height: 100%;
				padding: 0;
			}
		</style>
        <script src="../../js/jquery-1.9.1.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.mobile/1.3.1/jquery.mobile-1.3.1.min.js"></script>
	</head>
	<body>
		<div data-role="page" id="modify_user">
			<div data-role="header" data-theme="d" data-position="fixed">
				<h1>管理帳號</h1>
			</div>
			<div data-role="content" data-theme="c">
                <table data-role="table" data-mode="columntoggle" class="ui-responsive table-stroke">
                    <thead>
                        <tr>
                            <th data-priority="1">帳號名稱</th>
                            <th data-priority="2">Email</th>
                            <th>變更</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($db->select("user") as $d){ ?>
                        <tr>
                            <td><?php echo $d['username']; ?></td>
                            <td><?php echo $d['email'] ? $d['email'] : '<em>空白</em>'; ?></td>
                            <td><a data-role="button" data-mini="true" href="modifyuser.php?id=<?php echo $d['id']; ?>" data-rel="dialog">修改資料</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
			</div>
		</div>
	</body>
</html>
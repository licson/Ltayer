<?php
require(dirname(__FILE__) . '/../../core/require.php');
include(dirname(__FILE__) . '/../../database/database.php');

$admincheck = $db->select("user",array("username" => $_SESSION['login_username']));

$res = $db->select("setting",array("name"=>"system_name"));
$title = $res[0]["value"];

function url($path){
	if(preg_match('/^https?/',$path)){
		echo '../app_proxy.php?url=' . urlencode($path) . '&mobile=1';
	}
	else {
		echo '../' . $path;
	}
}

$user = $db->select("user", array("id" => $_GET["id"]));
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
                <h1><?php echo $title; ?></h1>
            </div>
            <div data-role="content" id="pane">
				<?php if($admincheck[0]["admin"] != "true"){ ?>
				<p>您沒有權限瀏覽設定頁面!</p>
				<?php } else { ?>
				<?php if (isset($_GET["con"]) && $_GET["con"] == "0") {
					echo '<div class="ui-body-e ui-content">修改完成</div>';
				} else if (isset($_GET["con"]) && $_GET["con"] == "1") {
					echo '<div class="ui-body-e ui-content">兩次輸入的密碼不一樣喔</div>';
				} ?>
				<h3><?php echo $user[0]["username"];?></h3>
				<form action="modify.php?id=<?php echo $_GET["id"];?>" method="post">
					<label for="email">電郵地址</label>
					<input type="email" id="email" name="email" placeholder="Email" value="<?php echo $user[0]["email"];?>">
					<label for="pass">修改密碼</label>
					<input type="password" id="pass" placeholder="修改密碼">
					<label for="pass2">確認密碼</label>
					<input type="password" id="pass2" placeholder="修改密碼">

					<label for="admin">管理員</label>
					<input type="checkbox" name="admin" id="admin" value="true" <?php if($user[0]["admin"] == "true"){echo "checked";} ?>/>
					<input type="submit" value="送出" />
				</form>
				
				<a href="deleteuser.php?id=<?php echo $_GET["id"]; ?>" data-role="button" data-theme="e" data-rel="dialog">刪除使用者</a>
				<?php } ?>
    		</div>
        </div>
	</body>
</html>
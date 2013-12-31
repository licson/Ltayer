<?php
if(!session_id()) session_start();

require_once('database/database.php');
if(file_exists('install/index.php')){
    header("Location: install/index.php");
}

$res = $db->select("setting", array("name"=>"system_name"));
$bg = $db->select("setting", array("name"=>"bg"));
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width" />
<title><?php echo htmlspecialchars($res[0]["value"]); ?> - 登入</title>
<link href="css/webos.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div class="login-container" id="login">
<?php echo isset($_GET['err']) ? (!!$_GET['err'] ? '<div class="error">登入時發生不明錯誤！</div>' : '<div class="error">帳戶／密碼錯誤，請檢查。</div>') : ''; ?>
<h1><?php echo htmlspecialchars($res[0]["value"]); ?></h1>
<form action="logincontroller.php" method="post">
<p><input type="text" name="username" placeholder="Username"/></p>
<p><input type="password" name="password" placeholder="Password"/></p>
<p><input type="submit" value="Login" /></p>
</form>
</div>
</body>
</html>
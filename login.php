<?php
if(!session_id()) session_start();
include('database.php');

$res = $db->select("setting",array("name"=>"system_name"));
$bg = $db->select("setting",array("name"=>"bg"));
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo htmlspecialchars($res[0]["value"]); ?> - 登入</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        background: url(<?php echo $bg[0]["value"]; ?>);
        font-family: arial, sans-serif;
    }
    .login {
        position: fixed;
        top: 15%;
        left: 30%;
        width: 40%;
        height: 70%;
        background: rgba(0,0,0,0.5);
        color: white;
        padding: 1em;
        box-sizing: border-box;
        border-radius: 5px;
    }
    .login input {
        display: block;
        width: 50%;
        height: 30px;
        font-size: 25px;
        margin: 0.5em auto;
        padding: 0.25em;
    }
    .login input[type=submit] {
        height: 40px;
		background: rgba(255,255,255,0.7);
		border: none;
    }
    .login input[type=submit]:hover {
		background: rgba(255,255,255,0.6);
    }
	.error {
		background:rgba(255,50,50,0.4);
		padding: 1em;
	}
	@media all and (min-width: 768px) and (max-width: 1023px) {
		.login {
			left: 20%;
			width: 60%;
		}
		.login input {
			width: 62%;
		}
	}
	@media all and (max-width: 767px) {
		.login {
			left: 10%;
			width: 80%;
		}
		.login input {
			width: 70%;
		}
	}
    </style>
</head>
<body>
	<div class="login">
		<?php echo isset($_GET['err']) ? (!!$_GET['err'] ? '<div class="error">登入時發生不明錯誤！</div>' : '<div class="error">帳戶／密碼錯誤，請檢查。</div>') : ''; ?>
		<h1><?php echo htmlspecialchars($res[0]["value"]); ?></h1>
		<form action="logincontroller.php" method="post">
			<input type="text" name="username" placeholder="用戶名稱"/>
			<input type="password" name="password" placeholder="密碼"/>
			<input type="submit" value="登入" />
		</form>
	</div>
</body>
</html>
<?php
session_start();
require('../core/require.php');
include('../database/database.php');

$admincheck = $db->select("user", array("username" => $_SESSION['login_username']));
if($admincheck[0]["admin"] != "true"){
    die("您沒有權限瀏覽設定頁面");
}

$user = $db->select("user", array("id" => $_GET["id"]));
?>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<link href="../css/webos.css" type="text/css" rel="stylesheet" />
<style>
body{
	width:50%;
	margin:0 auto;
  margin-top: 10px;
}
</style>
<div class="grid">
	<?php if (isset($_GET["con"]) && $_GET["con"] == "0") {
		echo '<div class="alert alert-success">修改完成</div>';
	} else if ($_GET["con"] == "1") {
		echo '<div class="alert alert-danger">兩次輸入的密碼不一樣喔</div>';
	}?>
	<h3><?php echo $user[0]["username"];?></h3>
<form role="form" action="modify.php?id=<?php echo $_GET["id"];?>" method="post">
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $user[0]["email"];?>">
  </div>
  <div class="form-group">
    <label for="pass">修改密碼</label>
    <input type="password" class="form-control" id="pass" name="pass" placeholder="修改密碼">
    <label for="pass2">確認密碼</label>
    <input type="password" class="form-control" id="pass2" name="pass2" placeholder="修改密碼">
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox" name="admin" id="admin" value="true" <?php if($user[0]["admin"]=="true"){echo "checked";} ?>/> 管理員
    </label>
  </div>
  <button type="submit" class="btn btn-default">送出</button>
</form>
<a href="deleteuser.php?id=<?php echo $_GET["id"]; ?>&username=<?php echo $user[0]["username"]; ?>" class="btn btn-danger">刪除使用者</a>
<a href="index.php" class="btn btn-info">回到控制台</a>
</div>
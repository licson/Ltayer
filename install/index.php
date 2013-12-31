<?php
$error = false;

function check($val){
    global $error;
    if($val){
    	echo "<span class=\"green\">√</span>";
	}
	else {
		$error = true;
		echo "<span style=\"color:red;\">Χ</span>";
	}
}

function check_php_version($version){
	check(phpversion() >= $version);
}

function check_extension($ext){
	check(extension_loaded($ext));
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ltayer 安裝程序</title>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
		<style>
			body {
    			background-color: #F1F1F1;
    			font-family: "Open Sans";
    			font-size: 15px;
    			color: #444;
			}
			.container {
    			background: #FFF;
    			width: 700px;
    			margin: 3em auto 0 auto;
    			padding: 20px 40px;
			}
			fieldset table {
    			width: 100%;
    			text-align: center;
			}
			label.error {
    			margin-left: 5px;
    			font-size: 100%;
    			color: red;
			}
			#licenses {
    			margin: 1.5em 0;
    			border-top: 1px solid #DDD;
    			border-bottom: 1px solid #DDD;
    			padding: 1em;
    			word-wrap: break-word;
    		}
			ul li {
    			list-style: square;
			}
			table {
    			border-radius: 5px;
    			width: 100%;
    			border-collapse: collapse;
			}
			table th {
    			background: #e1e1e1;
    			padding: 0.5em;
			}
			table td {
    			background: #f4f4f4;
    			padding: 0.5em;
			}
			.title  {
    			width: 100%;
    			float: left;
			}	
			.title img {
    			width: 250px;
    			height: auto;
    			vertical-align: bottom;
			}
			h1 {
    			font-family: "Open Sans";
    			font-weight: 300;
    			color: #444;
			}
			h2 {
    			font-family: "Open Sans";
    			font-weight: 300;
    			color: #444;
			}
			input[type="submit"] {
    			font-size: 100%;
    			cursor: pointer;
    			outline: 0;
    			padding: 15px 20px;
    			border: none;
    			color: #FFF;
    			border-radius: 3px;
    			background: #F3A133;
    			-o-transition: color .07s linear, background-color .07s linear, border-color .07s linear;
    			-webkit-transition: color .07s linear, background-color .07s linear, border-color .07s linear;
    			-moz-transition: color .07s linear, background-color .07s linear, border-color .07s linear;
    			transition: color .07s linear, background-color .07s linear, border-color .07s linear;
			}
			input[type="submit"]:hover {
    			background: #5C4B51;	
			}
			.datas span {
    			width: 150px;
    			display: inline-block;
			}
			input[type="text"], input[type="password"] {
    			width: 200px;
    			border: 1px solid #DDD;
    			padding: 5px 5px;
    			color: #666;
    			border-radius: 3px;
			}
			.green {
			    color: #8CBEB2;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<?php if(@$_GET['step']==NULL){ ?>
			<h1 class="title">
				<img src="ltayer.png" alt="Ltayer"><span> Installation </span>
				<span> 0 of 4 </span>
			</h1>
			<p>以下為 Ltayer 的安裝須知，請務必詳細後再進行安裝。</p>
			<form name="form1" method="post" action="index.php?step=1">
				<div id="licenses">
					<p>Ltayer 是個 MIT 開放原始碼專案，當您使用時，代表您已經同意了 MIT 授權條款。</p>
					<p>以下是維基百科對 MIT 授權之授權條款說明：</p>
					<ul>
						<li>被授權人有權利使用、複製、修改、合併、出版發行、散布、再授權及販售軟體及軟體的副本。</li>
						<li>被授權人可根據程式的需要修改授權條款為適當的內容。</li>
						<li>在軟體和軟體的所有副本中都必須包含版權聲明和許可聲明。</li>
					</ul>
					<p>除了授權以外，使用時請注意以下事情：</p>
					<ul>
						<li>您的資料 LTAY 無法取得，所以不用擔心我們會取走您的資料。</li>
						<li>如果因為有漏洞而導致您的資料外流，LTAY 不負任何責任，僅會修復漏洞。</li>
						<li>Ltayer 上的程式可能不是 LTAY 授權的，因次 LTAY 不對您所安裝的程式做任何負責。</li>
						<li>最後我們希望您能秉持著開源的精神，把 Ltayer 分享給大家。</li>
					</ul>
				</div>
				<p><input type="submit" name="button" id="button" value="我已經詳細閱讀以上須知且同意，請開始安裝"></p>
			</form>
			<?php } if( @$_GET['step'] == 1 ) { ?>
			<h1 class="title">
				<img src="ltayer.png" alt="Ltayer"><span> Installation </span>
				<span> 1 of 4 </span>
			</h1>
			<form name="form1" method="post" action="index.php?step=2">
				<h2>安裝環境檢測</h2>
				<table>
					<tr>
						<th width="30%">項目</th>
						<th width="25%">最低配置</th>
						<th width="25%">最佳配置</th>
						<th width="20%">檢測結果</th>
					</tr>
					<tr>
						<td>PHP</td>
						<td>5.2</td>
						<td>5.2~5.4</td>
						<td><?php check_php_version(5.2); ?></td>
					</tr>
					<tr>
						<td>GD函式庫</td>
						<td>1.6</td>
						<td >1.6以上</td>
						<td><?php check_extension('gd'); ?></td>
					</tr>
					<tr>
						<td>Multibyte String 函式庫</td>
						<td>必須支援</td>
						<td>必須支援</td>
						<td><?php check_extension('mbstring'); ?></td>
					</tr>
					<tr>
						<td>Mysqli 函式庫</td>
						<td>必須支援</td>
						<td>必須支援</td>
						<td><?php check_extension('mysqli'); ?></td>
					</tr>
				</table>
				<h2>權限檢測</h2>
				<table>
					<tr>
						<th width="30%">項目</th>
						<th width="25%">所需權限</th>
						<th width="20%">檢測結果</th>
					</tr>
					<tr>
						<td>database.php</td>
						<td>可寫</td>
						<td><?php check(is_writable('../database/database.php')); ?></td>
					</tr>
					<tr>
						<td>database-sample.php</td>
						<td>可讀</td>
						<td><?php check(is_readable('../database/database-sample.php')); ?></td>
					</tr>
				</table>
				<p><input type="submit" name="button" id="button" value="下一步"<?php if($error){ ?> disabled="disabled"<?php } ?>><?php if($error){ ?><span style="color:red;">您必須解決以上問題才能繼續安裝！</span><?php } ?></p>
			</form>
			<?php } ?>
			<?php if(@$_GET['step']==2){ ?>
			<script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
			<script type="text/javascript" src="../js/jquery.validate.js"></script>
			<script type="text/javascript">
				$(function(){
					$("#form1").validate({
						rules:{
							mysql_database:{required:true},
							mysql_username:{required:true},
							mysql_host:{required:true}
						}
					});
				});
			</script>
			<h1 class="title">
				<img src="ltayer.png" alt="Ltayer"><span> Installation </span>
				<span> 2 of 4 </span>
			</h1>
			<form class="datas" id="form1" name="form1" method="post" action="index.php?step=3">
				<h2>MySQL 連線資料</h2>
				<p><span>資料庫名稱：</span><input type="text" name="mysql_database" id="mysql_database" value=""></p>
				<p><span>連線帳號：</span><input type="text" name="mysql_username" id="mysql_username" value=""></p>
				<p><span>連線密碼：</span><input type="text" name="mysql_password" id="mysql_password" value=""></p>
				<p><span>MySQL伺服器：</span><input type="text" name="mysql_host" id="mysql_host" value=""></p>
				<h2>管理員資料</h2>
				<p><span>管理員帳號：</span><input type="text" name="admin_id" id="admin_id" value=""> ( 預設 : admin ) </p>
				<p><span>管理員密碼：</span><input type="password" name="admin_psd" id="admin_psd" value=""> ( 預設 : admin ) </p>
				<p><input type="submit" name="button" id="button" value="下一步"></p>
			</form>
			<?php }
				if(@$_GET['step'] == 3){
					$error = false;
					$errormsg = null;
					
					try {
						if(isset($_POST['mysql_database']) && $_POST['mysql_database'] != ''){
							$mysql_file = '../database/database.php';
							$mysql_sample_file = '../database/database-sample.php';
							$mysql_config = vsprintf(file_get_contents($mysql_sample_file), array(
								addslashes($_POST['mysql_database']),
								addslashes($_POST['mysql_username']),
								addslashes($_POST['mysql_password']),
								addslashes($_POST['mysql_host'])
							));
							
							file_put_contents($mysql_file,$mysql_config);
						}
						
						if($_POST['admin_id'] == NULL){
							$admin_id = "admin";
						} else {
							$admin_id = $_POST['admin_id'];
						}
						
						if($_POST['admin_psd'] == NULL){
							$admin_password = md5(sha1('admin'));
						} else {
							$admin_password = md5(sha1($_POST['admin_psd']));
						}
						
						require_once('../database/database.php');
						
						$query = file("../database/ltayer.sql");
						foreach($query as $val){
							$result = $db->ExecuteSQL($val);
							if(!$result){
                                throw new Exception($db->lastError);
							}
						}
						
						if(!$db->insert(array(
						    "username" => $admin_id,
						    "password" => $admin_password,
						    "admin" => "true"
						),"user")){
						    throw new Exception($db->lastError);
						}
						
						if(!$db->insert(array(
                            "name" => "win_" . $admin_id . "_pos",
                            "value" => "[]"
                        ),"setting")){
                            throw new Exception($db->lastError);
						}
					}
					catch (Exception $e) {
						$error = true;
						$errormsg = base64_encode(json_encode(array(
							'type' => 'SQL Insert Error',
							'line' => __LINE__,
							'file' => dirname(__FILE__) . ';' . __FILE__,
							'errormsg' => $e->getMessage(),
						)));
					}
					@mkdir("../fs/data/".$admin_id, 0777);
					
					if($error === false){
				?>
			<h1 class="title">
				<img src="ltayer.png" alt="Ltayer"><span> Installation </span>
				<span class="green"> Complete ! </span>
			</h1>
			<p>Ltayer 已安裝成功，為了保障您網站的安全，請在此選擇一種方式來處理此程序。</p>
			<form name="form1" method="post" action="index.php?step=4">
				<p><input type="radio" name="radio" id="radio" value="rename" checked="checked"> 重新命名此安裝程序</p>
				<p><input type="radio" name="radio" id="radio2" value="unlink"> 刪除此安裝程序</p>
				<p><input type="submit" name="button" id="button" value="確定"></p>
			</form>
			<?php
				}
				else {
			?>
			<h2 style="color:red;">Ltayer安裝不成功！</h2>
			<p>Ltayer安裝時發生錯誤！</p>
			<p>參考代碼：</p>
			<pre id="licenses"><?php echo $errormsg; ?></pre>
			<?php
				}
			}
				
			if(@$_GET['step']==4){
				if($_POST["radio"] == "rename"){
					rename("index.php", "index.txt");
				} else {
					unlink("index.php");
				
				}
			    header("Location: ../index.php");
			}
			?>
		</div>
	</body>
</html>
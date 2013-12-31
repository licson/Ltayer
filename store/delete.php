<?php
require_once('../core/require.php');
require_once('../database/database.php');

$appid = $_GET['appid'];
$icon = $_GET['icon'];
$url = $_GET['url'];
$name = $_GET['name'];
$cat = $_GET["cat"];
$nowcat = $_GET["nowcat"];
$author = $_GET["author"];

function installcheck($appkey, $appname){
  $res = $GLOBALS['db']->select('app', array('app_key' => $appkey));
  if($res[0]["name"] == $appname){
    return true;
  } else {
    return false;
  }
}

$check = installcheck($appid, $name); 

if(!$check){
	$statue = "uninstalled";
} else {
	$db->delete('app', array('app_key' => $appid));
	$statue = "success";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>移除<?php echo $name; ?> - Ltayer Store</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="utf-8" />
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/ionicons.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <script src="../js/jquery-1.9.1.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="center">
                <h2 class="center">移除 <?php echo $name; ?></h2>
            </div>
            <div class="app-status">
            <?php
            if ($statue == "uninstalled") {
                echo '<p class="alert alert-dismissable alert-danger">本App不存在</p>';
            } else if ($statue == "success"){
                echo '<p class="alert alert-dismissable alert-success">移除成功</p>';
            }
            ?>
            </div>
            <div class="box center<?php if($statue=="uninstalled"){ ?> installed<?php } ?>">
                <div class="app">
                    <div class="app-logo">
                        <img src="<?php echo $icon;?>"/>
                    </div>
                    <ul class="app-detail">
                        <li><i class="ion-bookmark"></i> 名稱: <span class="boxw"><?php echo $name; ?></span></li>
                        <li><i class="ion-link"></i> 網址: <span class="boxw"><?php echo $url; ?></span></li>
                        <li><i class="ion-ios7-pricetag"></i> 類別: <span class="boxw"><?php echo $cat; ?></span></li>
                        <li><i class="ion-android-social-user"></i> 作者: <span class="boxw"><a href="?au=<?php echo $author; ?>"><?php echo $author; ?></span></li>
                    </ul>
                    <a href="index.php?cat=<?php echo $nowcat; ?>" class="btn btn-info app-install">回到商城</a>
                </div>
            </div>
        </div>
    </body>
</html>
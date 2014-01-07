<?php
require(dirname(__FILE__) . '/../core/require.php');
include(dirname(__FILE__) . '/../database/database.php');

$appid = $_GET['appid'];
$icon = $_GET['icon'];
$url = $_GET['url'];
$name = $_GET['name'];
$cat = $_GET["cat"];
$nowcat = $_GET["nowcat"];
$author = $_GET["author"];
$perm = $_GET["perm"];

function installcheck($appkey, $appname){
    $res = $GLOBALS['db']->select('app', array('app_key' => $appkey));
    if($res[0]["name"] == $appname){
        return true;
    } else {
        return false;
    }
}

if(installcheck($appid,$name)){
	$statue="installed";
} else {
    $GLOBALS['db']->delete('app',array('app_key' => $appid));
	$GLOBALS['db']->insert(array("app_key"=>$appid,"canvas_url"=>$url,"logo"=>$icon,"name"=>$name,"perms"=>$perm),"app");
	$statue = "success";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>安裝 <?php echo $name; ?> - Ltayer Store</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta charset="utf-8" />
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="../assets/css/ionicons.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <script src="../assets/js/jquery-1.9.1.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="center">
                <h2 class="center">安裝 <?php echo $name; ?></h2>
            </div>
            <div class="app-status">
            <?php
            if ($statue=="installed") {
                echo '<p class="alert alert-dismissable alert-warning">本App已經安裝過了</p>';
            } else if ($statue == "notsuccess") {
                echo '<p class="alert alert-dismissable alert-danger">安裝失敗</p>';
            } else if ($statue=="success"){
                echo '<p class="alert alert-dismissable alert-success">安裝成功</p>';
            }
            ?>
            </div>
            <div class="box center<?php if($statue=="installed"){ ?> notsuccess<?php } else if($statue=="notsuccess"){ ?> installed<?php } ?>">
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

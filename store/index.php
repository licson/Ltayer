<?php
require(dirname(__FILE__) . '/../core/require.php');
include(dirname(__FILE__) . '/../database/database.php');

$cat = null;
$au = null;
if(isset($_GET["cat"])) $cat = $_GET["cat"];
if(isset($_GET["au"])) $au = $_GET["au"];

$list = @file_get_contents("http://server.ltay.net/applistget.php?cat=$cat&au=$au");
$applist = json_decode($list);

function installcheck($appkey, $appname){
	$res = $GLOBALS['db']->select('app', array('app_key' => $appkey));
	if($res[0]["name"] == $appname){
		return true;
	} else {
		return false;
	}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ltayer Store</title>
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
            <div class="row">
            	<div class="col-md-2 col-xs-2">
                    <ul class="nav nav-pills nav-stacked">
                        <li <?php if($cat==null){echo ' class="active" ';} ?>>
                            <a href="index.php">商城</a>
                        </li>
                        <li <?php if($cat=="game"){echo ' class="active" ';} ?>>
                            <a href="?cat=game">遊戲</a>
                        </li>
                        <li <?php if($cat=="productivity"){echo ' class="active" ';} ?>>
                            <a href="?cat=productivity">生產力工具</a>
                        </li>
                        <li <?php if($cat=="social"){echo ' class="active" ';} ?>>
                            <a href="?cat=social">社群</a>
                        </li>
                        <li <?php if($cat=="tool"){echo ' class="active" ';} ?>>
                            <a href="?cat=tool">工具</a></li>
                        <li <?php if($cat=="other"){echo ' class="active" ';} ?>>
                            <a href="?cat=other">其他</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-10 col-xs-10">
                <?php if(empty($list)){
                	echo "無法連線至 Ltayer Store";
                	exit();
                }
                if ($list == "true") {
                	echo "此類別沒有App";
                	exit();
                }
                
                if($au != NULL&& $cat == NULL){
                	echo '<h1>由';
                	echo $au;
                	echo '製作的Apps</h1>';
                }
                
                foreach($applist as $c){ ?>
                    <div class="box<?php if(installcheck($c->app_id, $c->name)){ ?> installed<?php } ?>">
                        <div class="app">
                            <div class="app-logo">
	                            <img src="<?php echo $c->icon;?>"/>
                            </div>
                            <ul class="app-detail">
                            	<li><i class="ion-bookmark"></i> 名稱: <span class="boxw"><?php echo $c->name; ?></span></li>
                            	<li><i class="ion-link"></i> 網址: <span class="boxw"><?php echo $c->url; ?></span></li>
                            	<li><i class="ion-ios7-pricetag"></i> 類別: <span class="boxw"><?php echo $c->category; ?></span></li>
                            	<li><i class="ion-android-social-user"></i> 作者: <span class="boxw"><a href="?au=<?php echo $c->author; ?>"><?php echo $c->author; ?></span></li>
                            </ul>
                            <?php if(installcheck($c->app_id, $c->name)){ ?>
                            	<a href="delete.php?appid=<?php echo $c->app_id; ?>&amp;icon=<?php echo $c->icon;?>&amp;url=<?php echo $c->url;?>&amp;name=<?php echo $c->name;?>&amp;author=<?php echo $c->author;?>&amp;cat=<?php echo $c->category;?>&amp;perm=<?php echo $c->perm;?>&amp;nowcat=<?php echo $cat;?>" class="btn btn-danger app-install">移除</a>
                            <?php } else { ?>
                            	<a href="install.php?appid=<?php echo $c->app_id; ?>&amp;icon=<?php echo $c->icon;?>&amp;url=<?php echo $c->url;?>&amp;name=<?php echo $c->name;?>&amp;author=<?php echo $c->author;?>&amp;cat=<?php echo $c->category;?>&amp;perm=<?php echo $c->perm;?>&amp;nowcat=<?php echo $cat;?>" class="btn btn-success app-install">安裝</a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </body>
</html>

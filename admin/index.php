<?php
require '../core/require.php';
include('../database/database.php');
$admincheck=$db->select("user",array("username"=>$_SESSION['login_username']));
if($admincheck[0]["admin"]!="true"){ die("您沒有權限瀏覽設定頁面"); }
$dockvalue=$db->select("setting",array("name"=>"dock"));
if($dockvalue[0]["value"]=="true"){ $dock="checked"; }else{$dock="";}
?>
<!doctype html>
<html>
    <head>
        <meta charest="utf-8" />
        <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/webos.css" type="text/css" rel="stylesheet" />
        <style>
        .clear {
            clear: both;
        }
        </style>
    </head>
    <body>
<div class="container">
    <div class="row">
        <div class="col-xs-6">
            <table class="table">
                <tr>
                    <td>帳號名稱</td>
                    <td>Email</td>
                    <td>變更</td>
                </tr>
                <?php foreach($db->select("user") as $d){ ?>
                <tr>
                    <td><?php echo $d['username']; ?></td>
                    <td><?php echo $d['email']; ?></td>
                    <td><a href="modifyuser.php?id=<?php echo $d['id']; ?>" class="btn btn-primary" style="color:white;">修改資料</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        
        <div class="col-xs-6">
            <h3>新增帳號</h3>
            <form action="newuser.php" method="post">
                <input type="text" name="username" id="username" placeholder="帳號" />
                <input type="text" name="password" id="password" placeholder="密碼"></br>
                <input type="checkbox" name="admin" value="true"/>管理員權限</br></br>
                <input type="submit" value="送出" />
            </form>
        </div>
    </div>
    <div class="row">

        <div class="col-xs-6">
            <h3>系統設定</h3>
            <form action="settingset.php" method="post">
                <p>
                背景圖片：<input type="text" name="bg" id="bg" value="<?php $res=$db->select("setting",array("name"=>"bg")); echo $res[0]["value"]; ?>" placeholder="背景圖片" />
                </p><p>
                系統名稱：<input type="text" name="system_name" id="system_name" value="<?php $res=$db->select("setting",array("name"=>"system_name")); echo $res[0]["value"]; ?> " placeholder="系統名稱" />
                </p><input type="submit" value="送出" />
            </form>
        </div>
        <div class="col-xs-6">
            <h3>特效</h3>
            <form action="setaffect.php" method="post">
                <p>
                <input type="checkbox" name="dock" value="true" <?php echo $dock; ?> />開啟Dock
                </p>
                <input type="submit" value="送出" />
            </form>
        </div>
        <div class="col-xs-6">
            <a class="btn btn-info" href="sysinfo.php" style="color:white;">取得伺服器資訊</a>
        </div>
   </div>
</div>
    </body>
</html>


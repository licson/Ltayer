<?php
require '../require.php';
include('../database.php');
?>
<!doctype html>
<html>
    <head>
        <meta charest="utf-8" />
        <style>
        .grid {
            width: 50%;
            float: left;
        }
        .grid form input {
            padding : 0.25em;
            margin: 1em auto;
            width: 70%;
            display: block;
        }
        .grid p {
            font-family: arial, sans-serif;
            font-size: 1.25em;
        }
        .clear {
            clear: both;
        }
        </style>
    </head>
    <body>
        <div class="grid">
            <p>新增帳號</p>
            <form action="newuser.php" method="post">
                <input type="text" name="username" id="username" placeholder="帳號" />
                <input type="text" name="password" id="password" placeholder="密碼">
                <input type="submit" value="送出" />
            </form>
        </div>
        <div class="grid">
            <p>系統設定</p>
            <form action="settingset.php" method="post">
                <input type="text" name="bg" id="bg" value="<?php $res=$db->select("setting",array("name"=>"bg")); echo $res[0]["value"]; ?>" placeholder="背景圖片" />
                <input type="text" name="system_name" id="system_name" value="<?php $res=$db->select("setting",array("name"=>"system_name")); echo $res[0]["value"]; ?> " placeholder="系統名稱" />
                <input type="submit" value="送出" />
            </form>
        </div>
        <div class="grid">
            <p>設定密碼</p>
            <form action="setpass.php" method="post">
                <input type="password" name="pass" id="pass" placeholder="密碼" />
                <input type="password" name="pass2" id="pass2" placeholder="確認密碼" />
                <input type="submit" value="送出" />
            </form>
        </div>
        <br class="clearfix" />
    </body>
</html>


<?php
//新增以下程式碼檢查權限
require '../../core/require.php';
include('../../database/database.php');


$usercheck=$db->select("user", array("username" => $_SESSION['login_username']));
if($usercheck[0]["username"] = "") die("您沒有權限新增記事");
include('appfunctions.php');

load_template('_header');
load_template('new_form');
load_template('_footer');
?>
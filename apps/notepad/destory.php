<?php
$id = $_GET['id'];

require '../../core/require.php';
include('../../database/database.php');

$usercheck=$db->select("user", array("username" => $_SESSION['login_username']));
$owen=$db->select("notepad", array("id" => $id));

if($usercheck[0]["username"] != $owen[0]["user_name"]) die("您沒有權限刪除此記事");
include_once('appfunctions.php');
include('action/destory_action.php');
redirect_to('index.php');
?>
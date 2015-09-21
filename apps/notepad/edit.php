<?php
$id = $_GET['id'];

//新增以下程式碼檢查權限
require '../../core/require.php';
include('../../database/database.php');

$usercheck=$db->select("user", array("username" => $_SESSION['login_username']));
$owen=$db->select("notepad", array("id" => $id));

if($usercheck[0]["username"] != $owen[0]["user_name"]) die("您沒有權限編輯此記事");
include('appfunctions.php');
//include('action/show_action.php?id='.$id);
include('helper/get_content.helper.php');


load_template('_header');
include('templates/edit_form.tpl.php');
load_template('_footer');

<?php
$id = $_GET['id'];

require '../../core/require.php';
include('../../database/database.php');

$usercheck=$db->select("user", array("username" => $_SESSION['login_username']));
$owen=$db->select("notepad", array("id" => $id));

if($usercheck[0]["username"] != $owen[0]["user_name"]) die("您沒有權限檢視此記事");
include('appfunctions.php');
include('action/show_action.php');
load_template('_header');

include('templates/show.tpl.php');
load_template('_footer');

?>
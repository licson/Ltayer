<?php
require('../require.php');
require('../database.php');
$bg = $_POST['bg'];
$system_name = $_POST['system_name'];
function Updateconfig($config,$name){
	$GLOBALS['db']->update('setting',array('value'=>$config),array('name'=>$name));
}
Updateconfig($bg,'bg');
Updateconfig($system_name,'system_name');
echo "設定完成，重新整理網頁以套用更新";
?>